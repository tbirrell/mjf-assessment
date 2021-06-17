<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="drink-row d-flex flex-row justify-content-between">
                            <div class="card drink"
                                 :class="{
                                    disabled: mgRemaining < (d.caffeine_per_serving)
                                 }"
                                 v-for="d in drinks">
                                <div class="fake-image" :style="{ backgroundImage: 'url(' + d.image_url + ')' }"></div>
                                <h3>{{ d.name }}</h3>
                                <div>{{ d.caffeine_per_serving }}mg per serving</div>
                                <div>{{ serving_text(d.servings) }}</div>
                                <div class="buttons">
                                    <button class="btn btn-primary" @click="addServing(d.id, d.caffeine_per_serving, 1)" :disabled="mgRemaining < d.caffeine_per_serving">Add Serving</button>
                                    <button class="btn btn-primary" v-if="d.servings > 1" @click="addServing(d.id, d.caffeine_per_serving, 2)" :disabled="mgRemaining < (d.caffeine_per_serving * 2)">Add Can</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 my-4">
                <div class="card">
                    <div class="card-body p-0">
                        <table class="table table-condensed mb-0">
                            <thead>
                            <tr>
                                <th class="border-top-0">Drink</th>
                                <th class="border-top-0">Servings</th>
                                <th class="border-top-0">mg Consumed</th>
                                <th class="border-top-0">Time</th>
                                <th class="remove-drink border-top-0">Remove</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(l,i) in drinkLog">
                                <td>{{ l.name }}</td>
                                <td>{{ l.servings }}</td>
                                <td>{{ l.caffeine * l.servings }}mg</td>
                                <td>{{ l.time | moment("hh:mma [on] MMMM Do YYYY") }}</td>
                                <td class="remove-drink x" @click="removeServing(l.id, i)">X</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4 my-4">
                <div class="card">
                    <div class="card-body mgCard">
                        <div class="mgRemaining">
                            {{ mgRemaining }}mg
                            <span>
                                remaining
                            </span>
                        </div>
                        <div class="mt-4">{{ lifetimeConsumption }}mg Lifetime Consumption</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from 'moment';

export default {
    props: {
        drinks: Array,
        drink_log: Array,
        lifetime_consumption: Number
    },
    data() {
        return {
            mgRemaining: 500,
            drinkLog: _.clone(this.drink_log),
            lifetimeConsumption: _.clone(this.lifetime_consumption)
        }
    },
    mounted() {
        this.drink_log.forEach((l) => {
            this.mgRemaining = this.mgRemaining - (l.caffeine * l.servings);
        });
        window.setInterval(() => {
            this.checkExpiredDrinks()
        }, 30 * 1000)
    },
    methods: {
        serving_text(servings) {
            return servings + ' serving' + (servings > 1 ? 's' : '');
        },
        addServing(id, caffeine, servings) {
            //save to DB
            axios.post('/save', {id, servings}).then((res) => {
                //adjust status
                this.mgRemaining = this.mgRemaining - (caffeine * servings);
                this.lifetimeConsumption = this.lifetimeConsumption + (caffeine * servings);

                //add to local log
                let drink = this.drinks.find((d) => d.id === id);
                let newLogId = Date.now()
                this.drinkLog.push({
                    id: res.data.id,
                    name: drink.name,
                    servings: servings,
                    caffeine: drink.caffeine_per_serving,
                    time: Date.now()
                })
            }).catch((err) => {
                let msg = err.response.data.errors;
                if ('id' in msg) {
                    alert(msg.id[0]);
                } else if ('servings' in msg) {
                    alert(msg.servings[0]);
                } else if ('drinks' in msg) {
                    alert(msg.drinks[0]);
                }
            })
        },
        removeServing(logID, localIndex) {
            //remove from DB
            axios.post('/delete', {id: logID}).then(res => {
                this.removeLocalDrink(localIndex);
            }).catch((err) => {
                let msg = err.response.data.errors;
                if ('id' in msg) {
                    alert(msg.id[0]);
                }
            });
        },
        checkExpiredDrinks() {
            this.drinkLog.forEach((l, i) => {
                if (moment(l.time).isBefore(moment().subtract(3, 'minutes'))) {
                    this.removeLocalDrink(i)
                }
            });
        },
        removeLocalDrink(index) {
            //adjust status
            let log = this.drinkLog[index];
            this.mgRemaining = this.mgRemaining + (log.caffeine * log.servings);
            this.lifetimeConsumption = this.lifetimeConsumption - (log.caffeine * log.servings);
            //remove from local list
            this.drinkLog.splice(index, 1);
        }
    }
}
</script>
