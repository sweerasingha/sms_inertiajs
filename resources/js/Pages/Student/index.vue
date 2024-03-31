<template>
    <AppLayout>
        <template #content>
            <div
                class="container flex flex-col items-center justify-center min-w-full bg-gray-900"
            >
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h1 class="page-title text-white">My Student List</h1>
                    </div>
                    <div
                        class="mt-4 w-full max-w-4xl rounded border py-4 px-4 mx-auto bg-gray-800 text-white"
                    >
                        <form @submit.prevent="taskStore">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="form-group mb-4">
                                        <label
                                            for="studentName"
                                            class="form-label"
                                            >Student Name</label
                                        >
                                        <input
                                            id="studentName"
                                            type="text"
                                            class="form-control"
                                            name="name"
                                            required
                                            v-model="task_form.name"
                                            placeholder="Enter student name"
                                            aria-label="Student name"
                                        />
                                    </div>
                                    <div class="form-group mb-4">
                                        <label
                                            for="studentAge"
                                            class="form-label"
                                            >Student Age</label
                                        >
                                        <input
                                            id="studentAge"
                                            type="text"
                                            class="form-control"
                                            name="age"
                                            required
                                            v-model="task_form.age"
                                            placeholder="Enter student age"
                                            aria-label="Student age"
                                        />
                                    </div>
                                    <div class="form-group mt-4">
                                        <input
                                            class="form-control"
                                            name="image"
                                            type="file"
                                            ref="file"
                                            accept="image/jpg, image/jpeg, image/png"
                                            aria-label="Upload student image"
                                        />
                                    </div>
                                </div>
                                <div class="col-lg-4 d-flex align-items-center">
                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                    >
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="mt-4 w-full max-w-4xl px-4 mx-auto">
                        <table class="table text-gray-300">
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
                                            :src="getImageUrl(student.image)"
                                            :alt="student.name"
                                            class="student-image"
                                        />
                                    </td>
                                    <td>{{ student.age }}</td>
                                    <td>
                                        <span
                                            v-if="student.status"
                                            class="badge bg-success"
                                            >Active</span
                                        >
                                        <span v-else class="badge bg-danger"
                                            >Inactive</span
                                        >
                                    </td>
                                    <td>
                                        <button
                                            class="btn btn-primary"
                                            @click.prevent="
                                                taskEditModal(student.id)
                                            "
                                        >
                                            <i
                                                class="fa-regular fa-pen-to-square"
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
                                            class="btn btn-info"
                                        >
                                            <i class="fa-regular fa-star"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
                    <div class="modal-content bg-gray-800 text-white">
                        <div class="modal-header border-b border-gray-700">
                            <h5 class="modal-title" id="taskEditLabel">
                                Edit Task
                            </h5>
                        </div>
                        <div
                            class="modal-body bg-gray-700"
                            id="taskEditContent"
                        >
                            <form @submit.prevent="taskUpdate">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="form-group mb-4">
                                            <input
                                                class="form-control bg-gray-600 border border-gray-600 text-white"
                                                name="title"
                                                type="text"
                                                v-model="task_update_form.name"
                                                placeholder="Enter task name"
                                                aria-label="Task name"
                                                required
                                            />
                                            <input
                                                class="form-control bg-gray-600 border border-gray-600 text-white mt-4"
                                                name="age"
                                                type="text"
                                                v-model="task_update_form.age"
                                                placeholder="Enter task age"
                                                aria-label="Task age"
                                                required
                                            />
                                            <input
                                                class="form-control bg-gray-600 border border-gray-600 text-white mt-4"
                                                name="imageupdate"
                                                type="file"
                                                ref="fileUpdate"
                                                accept="image/jpg, image/jpeg, image/png"
                                                aria-label="Update task image"
                                            />
                                        </div>
                                    </div>
                                    <div
                                        class="col-lg-4 d-flex align-items-center justify-content-center"
                                    >
                                        <button
                                            type="submit"
                                            class="btn bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded"
                                        >
                                            Update Task
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
    font-size: 3rem;
}

.table {
    background-color: #2d3748;
    border-collapse: collapse;
    width: 100%;
    & th,
    & td {
        border: 1px solid #4a5568;
        text-align: left;
        padding: 8px;
    }
    & th {
        background-color: #4a5568;
    }
}

.form-control {
    background-color: #2d3748;
    border: 1px solid #4a5568;
    color: white;
}

.btn {
    background-color: #3182ce;
    color: white;
    border: none;
    padding: 8px 16px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    transition-duration: 0.4s;
    cursor: pointer;
    &.btn-primary:hover {
        background-color: #63b3ed;
    }
    &.btn-danger {
        background-color: #e53e3e;
    }
    &.btn-success {
        background-color: #48bb78;
    }
}

.student-image {
    width: 70px;
    height: 70px;
    object-fit: cover;
}

.badge {
    display: inline-block;
    padding: 0.25em 0.4em;
    font-size: 75%;
    font-weight: 700;
    line-height: 1;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: 0.375rem;
    &.bg-success {
        background-color: #38a169;
    }
    &.bg-danger {
        background-color: #e53e3e;
    }
}
</style>
