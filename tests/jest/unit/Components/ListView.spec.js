import { shallowMount } from "@vue/test-utils";
import ListView from "@/Vue/Components/ListView.vue";
import ListTask from "@/Vue/Components/ListTask.vue";

describe("ListView.vue", () => {
    it("renders ListTask for each task in tasks prop", () => {
        const tasks = [
            { id: 1, description: "Task 1" },
            { id: 2, description: "Task 2" },
        ];
        const wrapper = shallowMount(ListView, {
            propsData: { tasks },
        });

        const listTaskComponents = wrapper.findAllComponents(ListTask);
        expect(listTaskComponents).toHaveLength(tasks.length);
    });

    it("emits reloadTasks when taskChanged is emitted from ListTask", async () => {
        const tasks = [{ id: 1, description: "Task 1" }];
        const wrapper = shallowMount(ListView, {
            propsData: { tasks },
        });

        wrapper.findComponent(ListTask).vm.$emit("taskChanged");
        await wrapper.vm.$nextTick();

        expect(wrapper.emitted().reloadTasks).toBeTruthy();
    });
});