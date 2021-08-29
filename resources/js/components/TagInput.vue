<template>
    <div>
        <input type="text"
               v-model="tag"
               placeholder="Enter a Tag"
               class="w-full border-none rounded p-2 bg-gray-100"
               @keydown.enter="addTag"
               @keydown.188="addTag"/>

        <div class="space-x-1 mt-2 flex flex-wrap">
            <span v-for="(tag, index) in tags" :key="index"
                  class="rounded-full bg-gray-800 text-gray-200 text-xs font-bold py-1 px-2 flex items-center mb-1">
                {{ tag }}

                <button @click="removeTag(index)" class="w-3" title="Remove">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </span>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            tags: [],
            tag: '',
        };
    },

    methods: {
        addTag() {
            let val = this.tag.trim();

            if (val.length === 0) {
                return;
            }

            if (this.tags.includes(val)) {
                this.tag = '';

                return;
            }

            this.tags.push(val);
            this.tag = '';

            this.$emit('tagsChanged', this.tags);
        },

        removeTag(index) {
            this.tags.splice(index, 1);

            this.$emit('tagsChanged', this.tags);
        },
    },
};
</script>
