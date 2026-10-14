<template>
    <div class="w-full h-full flex items-center justify-center gap-2">
        <RouterLink :to="{name : 'page-one'}" class="px-4 py-2 text-white rounded-lg bg-orange-500 ">Page One</RouterLink>
        <RouterLink :to="{name : 'page-two'}" class="px-4 py-2 text-white rounded-lg bg-orange-500 ">Page Two</RouterLink>
        <RouterLink :to="{name : 'page-three'}" class="px-4 py-2 text-white rounded-lg bg-orange-500 ">Page Three</RouterLink>
    </div>
</template>