<template>
       <button :class="classes" @click="subscribe">{{ text }}</button>
</template>


<script>
import axios from 'axios';
export default {
     props : ['active'],

    
     computed: {
            classes (){
                return ['btn subscribe', this.active ? 'btn-primary' : 'btn-default'];
            }, 
            text(){
              
                return  this.active ? 'Unsubscribe' : 'Subscribe';
            },
            endpoint(){
                return location.pathname == 'blank' ? 'threads/channel/thread/subscribe'
                                                     : location.pathname + '/subscribe';
            }
     },

     methods: {
         subscribe(){
             let action = this.active ? 'delete' : 'post'; 
             axios[action](this.endpoint);
              
             this.active = this.active ? false : true

         }
     }
}
</script>

