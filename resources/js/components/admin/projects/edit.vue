<script setup>
import Base from '../layouts/base.vue'
import { onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

let form = ref({
    title: '',
    description: '',
    link: '',
    photo: '',
    })
onMounted(async () => {
    getsingleProject()
})
const props = defineProps({
    id: {
        type: String,
        default: '',
    }
})

const getsingleProject = async () => {
    let response = await axios.get(`/api/get_edit_project/${props.id}`)
    console.log('response', response.data.project)
    form.value = response.data.project
}

const getPhoto = () => {
    let photo = "/img/upload/avatar.png";
    if (form.value.photo) {
        if (form.value.photo.indexOf("base64") != -1) {
            photo = form.value.photo;
        } else {
            photo = "/img/upload/" + form.value.photo;
        }
    }
    return photo;
};

const changePhoto = (e) => {
    let file = e.target.files[0];
    let reader = new FileReader();
    let limit = 4024 * 4024 * 7;
    if (file["size"] > limit) {
        swal({
            icon: "error",
            title: "Ooops...",
            text: "You are uploading a large file",
        });
        return false;
    }
    reader.onloadend = (file) => {
        form.value.photo = reader.result;
    };
    reader.readAsDataURL(file);
};

const updateProject = async () => {
    await axios.post(`/api/update_project/${form.value.id}`, form.value)
        .then((response) => {
            router.push('/admin/projects')
             toast.fire({
                icon: "success",
                title: "project updated successfully",
            });
        })
}

</script>

<template>
<Base/>
 <main class="main">
                <div class="main__sideNav"></div>

                <!-- Main Content -->
                <div class="main__content">
                     <!--===================EDIT PROJECT ====================-->
             <section class="about section" id="project">
                <div class="about_container">
                    <div class="titlebar">
                        <div class="titlebar_item">
                            <h1>Edit Project</h1>
                        </div>
                        <div class="titlebar_item">
                            <div class="btn btn-secondary" @click="updateProject()">
                                Update Project
                            </div>
                        </div>
                    </div>
                    <div class="card_wrapper">
                        <div class="wrapper_left">
                            <div class="card">

                                <p>Title</p>
                                <input type="text" class="input" v-model="form.title"/>

                                <p>Description</p>
                                <textarea cols="10" rows="5"  v-model="form.description"></textarea>

                                <p>Link</p>
                                <input type="text" class="input" v-model="form.link"/>

                            </div>
                        </div>

                        <div class="wrapper_right ">
                            <div class="card">
                                <div class="project_img-container">
                                 <img :src="getPhoto()" alt="" class="project_img">
                                </div>
                                <br>
                                <input type="file" id="fileimg" @change="changePhoto"/>
                                <br><br><br>
                            </div>
                        </div>

                    </div>
                    <div class="titlebar">
                        <div class="titlebar_item">

                        </div>
                        <div class="titlebar_item">
                            <div class="btn btn-secondary" @click="updateProject()">
                                Update Project
                            </div>
                        </div>
                    </div>
                </div>
            </section>
                </div>
</main>
</template>

