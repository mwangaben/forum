<template>
    <div v-if="signedIn">
        <div class="form-group">
        <textarea
                class="form-control"
                id="body" name="body"
                placeholder="Add a reply"
                rows="5"
                required
                v-model="body">
        </textarea>
        </div>
        <button
                class="btn btn-primary"
                type="submit"
                @click="addReply">
            Post
        </button>
    </div>
    <p class="text-center" v-else>
                Please
                <a href="/login">
                    sign in
                </a>
                to participate in this discussion
   </p>

</template>
<script>
    export default {
       props: ['endpoint'],
        data() {
            return {
                body: '',
            };
        },
        computed:{
        	signedIn() {
        		return window.App.signedIn;
        	}
        }, 

        methods: {
            addReply() {
                axios.post(this.endpoint, {body: this.body})
                    .then(({data}) => {

                        this.body = '';
                        flash('Your Reply has been posted');

                        this.$emit('created', data);
                    });


            }
        }
    }
</script>
