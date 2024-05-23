<template>
    <div>
        <h1>Hello World!</h1>
        <p>{{ message }}</p>
        <a :href="route('hello')">Hola!!!</a>
    </div>
</template>

<script>
export default {
    props: {
        message: {
            type: String,
            required: true
        }
    }
}
</script>
