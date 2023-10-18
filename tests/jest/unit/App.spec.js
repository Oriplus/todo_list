import { shallowMount } from '@vue/test-utils';
import App from '@/Vue/App.vue';

describe('App.vue', () => {
  it('mounts and renders', () => {
    const wrapper = shallowMount(App);
    expect(wrapper.html()).toContain('Tasks');
  });
});
