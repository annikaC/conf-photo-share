<template>
    <div class="upload-container bg-white rounded-none sm:rounded shadow-lg mt-2" v-cloak @drop.prevent="addFile"
         @dragover.prevent>
        <div class="p-4 font-bold bg-blue-700 rounded-none sm:rounded-t text-white">
            Upload your photo here
        </div>

        <div class="p-4">
            <div class="border-2 border-dashed p-8 text-center border-gray-300 cursor-pointer"
                 @click="$refs.fileInput.click()">
                <div class="flex justify-center">
                    <div class="w-10 text-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>

                <p><span class="font-bold">Drag and drop</span> to upload a file or click to upload manually</p>
            </div>

            <div class="p-2">
                <input id="fileInput" ref="fileInput" type="file" class="hidden" v-on:change="addFile"/>
                <label for="authorInput">Author Name</label>
                <input
                    id="authorInput"
                    ref="authorInput"
                    class="frounded p-1 bg-gray-300"
                    type="text"
                    placeholder="enter author"
                    v-model="authorName"
                />
            </div>

            <ul>
                <li v-for="file in files" class="bg-gray-100 p-2 mt-1 rounded flex">
                    <span class="flex-grow w-0 break-words">
                        {{ file.name }}
                        ({{ file.size | kb }} kb)
                    </span>

                    <button @click="removeFile(file)" title="Remove" class="w-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                  d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </li>
            </ul>
            <tag-input
            v-model="tags"
            />

            <button :disabled="uploadDisabled"
                    @click="upload"
                    class="w-full p-2 mt-2 text-white rounded"
                    :class="uploadDisabled ? 'bg-gray-300 cursor-not-allowed' : 'bg-gray-600'">
                Upload
            </button>
        </div>
    </div>
</template>

<script>
import TagInput from './TagInput';
export default {
    name: 'PhotoUpload',
    components: {
        TagInput
    },

    filters: {
        kb: function (value) {
            return Math.floor(value / 1024);
        },
    },

    data() {
        return {
            files: [],
            authorName: '',
            tags: ['hello', 'world'],
            uploading: false,
        };
    },

    computed: {
        uploadDisabled() {
            return this.files.length === 0 || this.uploading;
        },
    },

    methods: {
        addFile(event) {
            let droppedFiles = this.getFiles(event);

            // If there is no file.
            if (!droppedFiles) {
                return;
            }

            if (droppedFiles.length < 1) {
                return;
            }

            // Only one file please.
            if (this.files.length >= 1) {
                alert('Please only upload one file.');

                return;
            }

            // Only drag one file at a time please.
            if (droppedFiles.length > 1) {
                alert('Please only drag one file at a time.');

                return;
            }

            // Add dropped files.
            _.each([...droppedFiles], file => {
                if (file.type !== 'image/jpeg' && file.type !== 'image/png' && file.type !== 'image/gif') {
                    alert('Please only upload images.');

                    return;
                }

                this.files.push(file);
            });
        },

        async upload() {
            if (this.uploading) {
                return;
            }

            let formData = new FormData();

            if (this.files.length !== 1) {
                return;
            }

            formData.append('file', this.files[0]);
            formData.append('author', this.authorName);
            formData.append('tags', this.tags);

            this.uploading = true;

            try {
                await axios.post('/photos', formData);

                this.uploading = false;

                window.location.href = '/';
            } catch (error) {
                console.error(JSON.stringify(e.message));
            }
        },

        removeFile(file) {
            this.files = this.files.filter(f => {
                return f !== file;
            });
        },

        getFiles(event) {
            if (event.dataTransfer) {
                return event.dataTransfer.files;
            }

            if (event.target && event.target.id === 'fileInput') {
                return event.target.files;
            }

            return [];
        },
    },
};
</script>

<style scoped>
.upload-container {
    /* position: absolute; */
}
</style>
