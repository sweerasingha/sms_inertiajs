<template>
    <AppLayout>
        <template #content>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h1 class="page-title">My Student List</h1>
                    </div>
                    <div class="col-lg-12 mt-4">
                        <form @submit.prevent="taskStore">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <input
                                            class="form-control"
                                            name="title"
                                            type="text"
                                            v-model="task_form.name"
                                            placeholder="Add new task"
                                            aria-label="default input example"
                                            required
                                        />
                                        <input
                                            class="form-control"
                                            name="title"
                                            type="text"
                                            v-model="task_form.age"
                                            placeholder="Add new task"
                                            aria-label="default input example"
                                            required
                                        />
                                        <div class="form-group" mt-4>
                                            <input
                                                class="form-control"
                                                name="image"
                                                type="file"
                                                ref="file"
                                                placeholder="Default input"
                                                aria-label="default input example"
                                                accept="image/jpg, image/jpeg, image/png"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <button
                                        type="submit"
                                        class="btn btn-success"
                                    >
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-12 mt-4">
                        <div>
                            <table class="table table-success table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Age</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(student, index) in task_list"
                                        :key="index"
                                    >
                                        <th scope="row">{{ index + 1 }}</th>
                                        <td>{{ student.name }}</td>
                                        <td>
                                            <img
                                                :src="
                                                    getImageUrl(student.image)
                                                "
                                                :alt="student.name"
                                                style="
                                                    width: 70px;
                                                    height: 70px;
                                                "
                                            />
                                        </td>

                                        <td>{{ student.age }}</td>
                                        <td>
                                            <span
                                                v-if="student.status"
                                                class="badge bg-success"
                                            >
                                                Active
                                            </span>
                                            <span
                                                v-else
                                                class="badge bg-danger"
                                            >
                                                Inactive
                                            </span>
                                        </td>
                                        <td>
                                            <button
                                                class="btn btn-primary"
                                                @click.prevent="
                                                    taskEditModal(student.id)
                                                "
                                            >
                                                <i
                                                    class="fa-solid fa-check"
                                                ></i>
                                            </button>

                                            <button
                                                @click.prevent="
                                                    deleteTask(student.id)
                                                "
                                                class="btn btn-danger"
                                            >
                                                <i
                                                    class="fa-solid fa-trash-can"
                                                ></i>
                                            </button>
                                            <button
                                                @click.prevent="
                                                    studentStatus(student.id)
                                                "
                                                class="btn btn-success"
                                            >
                                                <i
                                                    class="fa-solid fa-check"
                                                ></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template #modal>
            <div
                class="modal fade"
                id="taskEdit"
                tabindex="-1"
                role="dialog"
                aria-labelledby="taskEditLabel"
                aria-hidden="true"
            >
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="taskEditLabel">
                                Main Task Edit
                            </h5>
                        </div>
                        <div class="modal-body" id="taskEditContent">
                            <form @submit.prevent="taskUpdate">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <input
                                                class="form-control"
                                                name="title"
                                                type="text"
                                                v-model="task_update_form.name"
                                                placeholder="Add new task"
                                                aria-label="default input example"
                                                required
                                            />
                                            <input
                                                class="form-control"
                                                name="title"
                                                type="text"
                                                v-model="task_update_form.age"
                                                placeholder="Add new task"
                                                aria-label="default input example"
                                                required
                                            />
                                            <div class="form-group" mt-4>
                                                <input
                                                    class="form-control"
                                                    name="imageupdate"
                                                    type="file"
                                                    ref="fileUpdate"
                                                    placeholder="Default input"
                                                    aria-label="default input example"
                                                    accept="image/jpg, image/jpeg, image/png"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <button
                                            type="submit"
                                            class="btn btn-success"
                                        >
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/App.vue";
import { usePage } from "@inertiajs/inertia-vue3";
import { computed } from "@vue/reactivity";
import axios from "axios";

export default {
    components: {
        AppLayout,
    },
    data() {
        return {
            task_form: {
                name: "",
                age: "",
            },
            task_update_form: {
                name: "",
                age: "",
            },
            task_list: [],
        };
    },
    beforeMount() {
        this.getTasks();
    },
    methods: {
        getImageUrl(imagePath) {
            // Adjust this based on where your application is hosted
            const baseUrl = window.location.origin;
            return `${baseUrl}/${imagePath}`;
        },

        async getTasks() {
            const tasks = (await axios.get(route("student.list"))).data;
            this.task_list = tasks;
        },
        async taskStore() {
            const formData = new FormData();
            formData.append("name", this.task_form.name);
            formData.append("age", this.task_form.age);
            if (this.$refs.file.files[0]) {
                formData.append("image", this.$refs.file.files[0]);
            }

            try {
                await axios.post(route("student.store"), formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                });
                this.getTasks();
                this.task_form.name = "";
                this.task_form.age = "";
                // Reset file input
                if (this.$refs.file) {
                    this.$refs.file.value = "";
                }
            } catch (error) {
                console.error("Error:", error.response);
            }
        },
        async deleteTask(id) {
            await axios.delete(route("student.delete", id));
            this.getTasks();
        },
        async studentStatus(id) {
            await axios.get(route("student.status", id));
            this.getTasks();
        },
        async taskEditModal(id) {
            const task = (await axios.get(route("student.get", id))).data;
            this.task_update_form = task;
            $("#taskEdit").modal("show");
        },
        async taskUpdate() {
            const formData = new FormData();
            formData.append("name", this.task_update_form.name);
            formData.append("age", this.task_update_form.age);
            if (this.$refs.fileUpdate.files.length > 0) {
                formData.append("image", this.$refs.fileUpdate.files[0]);
            }

            try {
                await axios.post(
                    route("student.update", { id: this.task_update_form.id }),
                    formData,
                    {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                    }
                );
                this.getTasks();
                $("#taskEdit").modal("hide");
                // After update actions...
            } catch (error) {
                console.error("Error:", error.response);
            }
        },
    },
};
</script>

<style lang="scss" scoped>
.page-title {
    padding-top: 5vh;
    font-size: 5rem;
    color: rgb(10, 205, 124);
}
</style>
