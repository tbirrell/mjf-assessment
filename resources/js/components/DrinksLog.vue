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
                                <th class="remove-drink border-top-0" @click="removeServing(l.id)">Remove</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="l  in drink_log">
                                <td>{{ l.name }}</td>
                                <td>{{ l.servings }}</td>
                                <td>{{ l.caffeine * l.servings }}mg</td>
                                <td>{{ l.time | moment("hh:mma [on] MMMM Do YYYY") }}</td>
                                <td class="remove-drink x">X</td>
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
                        </div>
                        <div>
                            remaining
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        drinks: Array,
        drink_log: Array
    },
    data() {
        return {
            mgRemaining: 500
        }
    },
    mounted() {
        this.drink_log.forEach((l) => {
            this.mgRemaining = this.mgRemaining - (l.caffeine * l.servings);
        });
    },
    methods: {
        serving_text(servings) {
            return servings + ' serving' + (servings > 1 ? 's' : '');
        },
        addServing(id, caffeine, servings) {
            //adjust status
            this.mgRemaining = this.mgRemaining - (caffeine * servings);

            //add to local log
            let drink = this.drinks.find((d) => d.id === id);
            let newLogId =  Date.now()
            this.drink_log.push({
                id: newLogId,
                name: drink.name,
                servings: servings,
                caffeine: drink.caffeine_per_serving,
                time: Date.now()
            })

            //save to DB
            axios.post('/save', {
                id,
                servings,
            }).then((res) => {
                let logIndex = this.drink_log.findIndex((d) => d.id === newLogId);
                this.drink_log[logIndex].id = res.data;
            })
        },
        removeServing(id) {

        }
    }
}
</script>
