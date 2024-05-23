<template>
  <div class="form-group" :class="[{ 'custom-form-field': controls }]">
    <label :for="name" class="col-form-label">{{ label }}</label>
    <input
        :type="type"
        class="form-control"
        :class="{'is-invalid': isError}"
        :id="name"
        :value="modelValue"
        @input="updateValue($event.target.value)"
        @blur="validate"
        :required="isRequired"
        :minlength="minLength"
        :maxlength="maxLength"
        :pattern="pattern"
    />

    <div v-if="isError" class="invalid-feedback">
      {{ errorMessage }}
    </div>
    <div v-if="controls" class="custom-button">
      <button class="btn btn-sm btn-primary" type="button" @click="openFieldsModal">
        <i class="fa fa-pen-clip"></i>
      </button>
      <button class="btn btn-sm btn-danger" type="button" @click="deleteField">
        <i class="fa fa-trash"></i>
      </button>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    name: {
      type: String,
      required: true
    },
    label: {
      type: String,
      required: true
    },
    modelValue: {
      type: [String, Number],
      default: ''
    },
    type: {
      type: String,
      default: 'text'
    },
    colSize: {
      type: String,
      default: 'col-md-6'
    },
    validationRules: {
      type: String,
      default: ''
    },
    controls:{
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      errorMessage : null,
      isError : false
    }
  },
  computed: {
    isRequired() {
      return this.validationRules && this.validationRules.includes('required');
    },
    minLength() {
      const match = this.validationRules && this.validationRules.match(/min:(\d+)/);
      return match ? match[1] : null;
    },
    maxLength() {
      const match = this.validationRules && this.validationRules.match(/max:(\d+)/);
      return match ? match[1] : null;
    },
    pattern() {
      const match = this.validationRules && this.validationRules.match(/pattern:(.+)/);
      return match ? match[1] : null;
    },
  },
  methods: {
    updateValue(newValue) {
      this.$emit('update:modelValue', newValue);
    },
    validate() {
      if (this.validationRules !== null){
        const rules = this.validationRules.split('|');
        for (let rule of rules) {
          if (rule === 'required' && !this.modelValue) {
            this.setErrorMessage('Este campo es obligatorio');
            return;
          }

          const [ruleType, ruleValue] = rule.split(':');
          switch (ruleType) {
            case 'pattern':
              if (!new RegExp(ruleValue).test(this.modelValue)) {
                this.setErrorMessage('El formato del campo es incorrecto');
                return;
              }
              break;
            case 'min':
              if (this.modelValue.length < parseInt(ruleValue)) {
                this.setErrorMessage(`La longitud mínima es ${ruleValue}`);
                return;
              }
              break;
            case 'max':
              if (this.modelValue.length > parseInt(ruleValue)) {
                this.setErrorMessage(`La longitud máxima es ${ruleValue}`);
                return;
              }
              break;
              // Puedes añadir más reglas según sea necesario...
          }
        }
      }
      this.setErrorMessage('');
      this.isError = false;
    },
    setErrorMessage(message) {
      this.errorMessage = message;
      this.isError = true;
    },
    openFieldsModal() {
      this.$emit('open-fields-modal');
    },

    deleteField() {
      this.$emit('delete-field');
    },
  }
};
</script>

<style scoped>
.custom-form-field {
  border: 2px solid blue; /* Cambia este color al color de tu borde */
  padding: 1rem;
  border-radius: 0.25rem;
  position: relative;
  background: #fff; /* Cambia este color al de tu fondo si es necesario */
}

.custom-button {
  position: absolute;
  top: 0rem;
  right: 0rem;
}
</style>

