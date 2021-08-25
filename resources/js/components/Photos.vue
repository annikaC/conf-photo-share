<template>
    <div class="p-6">
        <h1 class="text-3xl mb-4">Uploaded Photos</h1>

        <PhotoUpload />

        <div class="grid-cols-3 gap-4 hidden md:grid">
            <div v-for="partition in partitionedPhotos">
                <div v-for="photo in partition" :key="photo.id">
                    <img :src="photo.url" class="w-full mt-4 object-cover rounded-lg" />
                    <h3>Uploaded by - Upload Name</h3>
                    <ul class="tags">
                        <li> Tag 1 </li>
                        <li> Tag 2 </li>
                        <li> Tag 3 </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import PhotoUpload from './PhotoUpload.vue';

export default {
    name: 'Photos',
    components: {
        PhotoUpload
    },
    data() {
        return {
            photos: [],
        };
    },
    mounted() {
        this.loadPhotos();
        this.setupWebsockets();
    },
    computed: {
        partitionedPhotos() {
            return this.partition(this.photos, 3);
        }
    },
    methods: {
        partition(photos, size) {
            let index = 0;

            return _.groupBy(
                photos,
                () => {
                    if (index === size) {
                        index = 0;
                    }

                    index++;

                    return (index - 1) % size;
                }
            );
        },

        async loadPhotos() {
            try {
                let {data: response} = await axios.get('/photos');

                this.photos = response.data;
            } catch (error) {
                console.error(error);
                alert('Unable to load photos!');
            }
        },

        handlePhotoUploaded(event) {
            if (!event || !event.photo) {
                return;
            }

            let photo = JSON.parse(event.photo);

            this.photos.unshift(photo);
        },

        setupWebsockets() {
            Echo.channel('main-channel').listen('PhotoUploaded', this.handlePhotoUploaded);
        },
    },
};
</script>

<style scoped>
.tags {
    display: inline-flex;
}
.tags li {
    padding: 6px;
    background: pink;
    border-radius: 6px;
    margin: 0 4px 0 0;
}
</style>
