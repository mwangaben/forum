<template>
    <div>
        <div v-for="(reply, index) in items" :key="reply.id">
            <reply :data="reply" @deleted="remove(index)"></reply>
        </div>
        <paginator :dataSet="dataSet"></paginator>
        <new-reply :endpoint="location" @created="add"></new-reply>
    </div>
</template>
<script>
    import Reply from './Reply.vue';
    import NewReply from './NewReply.vue';
    import Collection from '../mixins/Collection';

    export default {

        components: {
            Reply, NewReply

        },
        mixins: [Collection],

        data() {
            return {
                dataSet: false,
                location: location.pathname+'/replies',
            }
        },
        created() {
            this.fetch();
        },

        methods: {

            fetch(){
                axios.get(this.url())
                .then(this.refresh);
            }, 

            url() {
                return `${location.pathname}/replies`;
            },

            refresh({data}) {
                this.dataSet = data;
                this.items = data.data;
            }

        }
    }
</script>
