export const descriptionClassMixin = {
    computed: {
        descriptionClass() {
            return {
                "is-invalid": this.error && !this.task.description.trim(),
                "form-control": true,
            };
        },
    },
};
