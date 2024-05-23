<template>
    <div :class="width_column">
        <div class="card">
            <div class="card-header" :style="{ backgroundColor: color_header, color: font_color_header }">
                {{ title_header }}

                <div class="card-tools" v-if="controls">
                    <slot name="controls"></slot>
                </div>
            </div>
            <div class="card-body">
                <slot name="content"></slot>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Card',
    props: {
        color_header: {
            type: String,
        },
        font_color_header: {
            type: String,
        },
        title_header: {
            type: String,
        },
        width_column: {
            type: String,
        },
        controls: {
            type: Boolean,
            default : false
        }
    }
}
</script>

<style>
.card-header{
    font-weight: bold;
}
</style>
