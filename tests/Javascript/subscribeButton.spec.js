import {mount} from 'vue-test-utils';
import SubscribeButton from '../../resources/assets/js/components/SubscribeButton.vue';
import expect from 'expect';
import Helpers from 'mwangaben-vthelpers';
import moxios from 'moxios'




describe('SubscribeButton', () => {
    let wrapper, b;

    beforeEach(() => {
        moxios.install();
        wrapper = mount(SubscribeButton);

        b = new Helpers(wrapper, expect);

        // wrapper.setProps({isActive : 'true'});
    });

    afterEach(() => {
        moxios.uninstall();
    })


   it('It display subscribe button to subscribe when subscription is not active', () => {
        wrapper.setProps({ active : false });
        b.see('Subscribe');
   });

   it('It displays unsubscribe when the subscription is active', (done) => {
       wrapper.setProps({ active : false});

       moxios.stubRequest('threads/channel/thread/subscribe', {
           status : 200
       })
       
      
       b.click('.subscribe');
       
       moxios.wait(() =>  {
           b.see('Unsubscribe');
           done()
       })


   })
})