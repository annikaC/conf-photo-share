<template>
    <div class="upload-container bg-white rounded-none sm:rounded shadow-lg mt-2"
         @drop.prevent="addFile"
         @dragover.prevent
         v-cloak>
        <div class="p-4 font-bold bg-blue-700 rounded-none sm:rounded-t text-white">
            Upload your photo here
        </div>

        <div class="p-4 space-y-2">
            <div class="border-2 border-dashed rounded p-8 text-center border-gray-300 cursor-pointer"
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

            <input id="fileInput" ref="fileInput" type="file" class="hidden" v-on:change="addFile" multiple>

            <ul class="space-y-1">
                <FileRow v-for="(file, index) in files" :key="index" :file="file" @remove="removeFile(index)"/>
            </ul>

            <TagInput @tagsChanged="updateTags"/>

            <button :disabled="uploadDisabled"
                    @click="upload"
                    class="w-full p-2 text-white rounded"
                    :class="uploadDisabled ? 'bg-gray-300 cursor-not-allowed' : 'bg-gray-600'">
                Upload
            </button>
        </div>
    </div>
</template>

<script>
import TagInput from './TagInput';
import FileRow from './FileRow';

export default {
    name: 'PhotoUpload',

    components: {
        FileRow,
        TagInput,
    },

    data() {
        return {
            files: [],
            tags: [],
            uploading: false,
        };
    },

    computed: {
        uploadDisabled() {
            return !this.files.length || this.uploading;
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

            // Add dropped files.
            for (const droppedFile of droppedFiles) {
                if (droppedFile.type !== 'image/jpeg' && droppedFile.type !== 'image/png' && droppedFile.type !== 'image/gif') {
                    alert('Please only upload images.');

                    return;
                }

                this.files.push({ status: 1, data: droppedFile });
            }
        },

        async upload() {
            if (this.uploading) {
                return;
            }

            this.uploading = true;

            for (const [index, file] of this.files.entries()) {
                let formData = new FormData();

                formData.append('file', file.data);
                formData.append('tags', this.tags);

                file.status = 2;

                try {
                    await axios.post('/photos', formData);

                    file.status = 3;

                    setTimeout(() => {
                        this.files.splice(index, 1);
                    }, 500);
                } catch (error) {
                    file.status = 4;

                    console.error(error);
                }
            }

            this.uploading = false;
        },

        removeFile(index) {
            this.files.splice(index, 1);
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

        updateTags(newTags) {
            this.tags = newTags;
        },
    },
};
</script>
