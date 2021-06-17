<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="drink-row d-flex flex-row justify-content-between">
                            <div class="card drink" v-for="d in drinks">
                                <div class="fake-image" :style="{ backgroundImage: 'url(' + d.image_url + ')' }"></div>
                                <h3>{{ d.name }}</h3>
                                <div>{{ d.caffeine_per_serving }} per serving</div>
                                <div>{{ serving_text(d.servings) }} </div>
                                <div class="buttons">
                                    <button class="btn btn-primary" >Add Serving</button>
                                    <button class="btn btn-primary" v-if="d.servings > 1">Add Can</button>
                                </div>
                            </div>
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
        return {}
    },
    methods: {
        serving_text(servings) {
            return servings + ' serving' + (servings > 1 ? 's' : '');
        }
    }
}
</script>
