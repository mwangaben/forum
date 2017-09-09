<template>
    <button :class="classes" type="submit" @click="toggle">
        <span class="glyphicon glyphicon-heart"></span>
        <span v-text="favoritesCount"></span>
    </button>
</template>
<script>
export default {
    props: ['reply'],

    data() {
        return {
            favoritesCount: this.reply.favoritesCount,
            isFavorited: this.reply.isFavorited
        }
    },

    computed: {
        classes() {
            return ['btn', this.isFavorited ? 'btn-primary' : 'btn-default']
        },

        endpoint() {
            return '/replies/' + this.reply.id + '/favorites';
        }
    },

    methods: {
        toggle() {
            return this.isFavorited ? this.destroy() : this.create();
        },

        create() {
            axios.post(this.endpoint);
            this.isFavorited = true;
            this.favoritesCount++;
            flash('You have favorited');

        },

        destroy() {
            axios.delete(this.endpoint);
            this.isFavorited = false;
            this.favoritesCount--;
            flash('You have unfavorited');

        }
    }
}
</script>
