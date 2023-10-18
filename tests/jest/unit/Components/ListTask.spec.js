import { shallowMount } from "@vue/test-utils";
import ListTask from "@/Vue/Components/ListTask.vue";
import { update, destroy } from "@/service.js";

jest.mock("@/service.js");

describe("ListTask.vue", () => {
    afterEach(() => {
        jest.clearAllMocks();
    });

    it("shows task description correctly", () => {
        const mockTask = {
            id: 1,
            description: "Test Task",
            status_id: 1,
        };
        const wrapper = shallowMount(ListTask, {
            propsData: {
                taskItem: mockTask,
            },
        });
        expect(wrapper.text()).toContain("Test Task");
    });

    it("toggles isEditing on startEditing", async () => {
        const mockTask = {
            id: 1,
            description: "Test Task",
            status_id: 1,
        };
        const wrapper = shallowMount(ListTask, {
            propsData: {
                taskItem: mockTask,
            },
        });
        await wrapper.vm.startEditing();
        expect(wrapper.vm.isEditing).toBe(true);
    });

    it("updates status on updateStatus", async () => {
        update.mockResolvedValue();

        const mockTask = {
            id: 1,
            description: "Test Task",
            status_id: 1,
        };
        const wrapper = shallowMount(ListTask, {
            propsData: {
                taskItem: mockTask,
            },
        });

        await wrapper.vm.updateStatus();
        expect(update).toHaveBeenCalled();
        expect(wrapper.emitted().taskChanged).toBeTruthy();
    });

    it("deletes task on deleteTask", async () => {
        destroy.mockResolvedValue();

        const mockTask = {
            id: 1,
            description: "Test Task",
            status_id: 1,
        };
        const wrapper = shallowMount(ListTask, {
            propsData: {
                taskItem: mockTask,
            },
        });

        await wrapper.vm.deleteTask();
        expect(destroy).toHaveBeenCalledWith(mockTask.id);
        expect(wrapper.emitted().taskChanged).toBeTruthy();
    });
});
