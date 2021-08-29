<template>
    <li class="hover:bg-gray-100 p-2 rounded flex items-center">
        <span class="flex-grow w-0 break-words">
            {{ file.data.name }}
            ({{ file.data.size | kb }} kb)
        </span>

        <button @click="$emit('remove')" title="Remove" class="w-4" v-if="file.status === 1">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <div class="flex justify-center items-center" v-if="file.status === 2">
            <svg class="animate-spin h-5 w-5 text-black" xmlns="http://www.w3.org/2000/svg" fill="none"
                 viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>

        <span class="bg-green-200 text-green-800 rounded-full py-1 px-2 text-xs font-bold uppercase"
              v-if="file.status === 3">
            Done
        </span>

        <span class="bg-red-200 text-red-800 rounded-full py-1 px-2 text-xs font-bold uppercase"
              v-if="file.status === 4">
            Failed
        </span>
    </li>
</template>

<script>
export default {
    name: 'FileRow',

    props: {
        file: {
            type: Object,
            required: true,
        },
    },

    filters: {
        kb: function (value) {
            return Math.floor(value / 1024);
        },
    },
};
</script>
