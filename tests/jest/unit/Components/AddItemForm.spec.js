import { shallowMount } from "@vue/test-utils";
import AddItemForm from "@/Vue/Components/AddItemForm.vue";
import { store } from "@/service.js";

jest.mock("@/service.js");

describe("AddItemForm.vue", () => {
    afterEach(() => {
        jest.clearAllMocks();
    });

    it("disables the button when task.description is empty", () => {
        const wrapper = shallowMount(AddItemForm);
        expect(wrapper.find("#btn-add").classes()).toContain("btn-secondary");
    });

    it("enables the button when task.description is not empty", async () => {
        const wrapper = shallowMount(AddItemForm);
        await wrapper.setData({ task: { description: "Test Task" } });
        expect(wrapper.find("#btn-add").classes()).toContain("btn-success");
    });

    it("calls store method on click", async () => {
        store.mockResolvedValue();
        const wrapper = shallowMount(AddItemForm);
        const mockTask = { description: "Test Task" };
        await wrapper.setData({ task: { description: "Test Task" } });
        await wrapper.find("#btn-add").trigger("click");
        expect(store).toHaveBeenCalled();
    });

    it("emits reloadTasks when task is added", async () => {
        store.mockResolvedValue();
        const wrapper = shallowMount(AddItemForm);
        await wrapper.setData({ task: { description: "Test Task" } });
        await wrapper.find("#btn-add").trigger("click");
        expect(wrapper.emitted().reloadTasks).toBeTruthy();
    });

    it("sets error when there is an issue adding the task", async () => {
        const errorMessage = "Test Error Message";
        store.mockRejectedValue({
            response: { data: { errors: { description: [errorMessage] } } },
        });
        const wrapper = shallowMount(AddItemForm);
        await wrapper.setData({ task: { description: "Test Task" } });
        await wrapper.find("#btn-add").trigger("click");
        expect(wrapper.vm.error).toBe(errorMessage);
    });
});
