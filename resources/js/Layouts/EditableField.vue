<template>
    <div>
      <label class="block mb-2 text-sm font-bold text-gray-700">{{ formatFieldLabel(key) }}</label>
      <template v-if="key === 'child_dob'">
        <input
          class="input-field"
          :type="getInputType(key, value)"
          v-model="editFields[key]"
          :max="maxDate"
          :class="{'border-red-500': !isChildDobValid}"
          @input="validateChildDob"
        />
        <p v-if="!isChildDobValid" class="mt-1 text-xs text-red-500">
          Date of birth must be at least 1 month ago and cannot be in the future.
        </p>
      </template>
      <template v-else-if="key === 'child_xname'">
        <select class="input-field" v-model="editFields[key]">
          <option v-for="suffix in suffixes" :key="suffix.value" :value="suffix.value">
            {{ suffix.label }}
          </option>
        </select>
      </template>
      <template v-else-if="alphabetOnlyFields.includes(key)">
        <input
          class="input-field"
          :type="getInputType(key, value)"
          v-model="editFields[key]"
          @input="validateAlphabetOnly(key, 'editFields')"
        />
      </template>
      <template v-else-if="numberOnlyFields.includes(key)">
        <input
          class="input-field"
          :type="getInputType(key, value)"
          v-model="editFields[key]"
          @input="validateNumber(key, 'editFields')"
        />
      </template>
      <template v-else-if="key === 'ref_cnum'">
        <input
          class="input-field"
          :type="getInputType(key, value)"
          v-model="editFields[key]"
          @input="validateTelephoneNumber(key, 'editFields')"
        />
      </template>
      <template v-else-if="workExperienceDateFields.includes(key)">
        <input
          class="input-field"
          type="date"
          v-model="editFields[key]"
          :max="maxDate"
        />
      </template>
      <input v-else class="input-field" :type="getInputType(key, value)" v-model="editFields[key]" />
    </div>
  </template>
  
  <script>
  export default {
    props: {
      key: String,
      value: [String, Number, Date],
      editFields: Object,
      maxDate: String,
      suffixes: Array,
      isChildDobValid: Boolean,
      alphabetOnlyFields: Array,
      numberOnlyFields: Array,
      workExperienceDateFields: Array,
    },
    methods: {
      formatFieldLabel(key) {
        return key.charAt(0).toUpperCase() + key.slice(1).replace(/_/g, ' ');
      },
      getInputType(key, value) {
        if (this.isDate(value)) {
            return 'date';
        } else if (this.isNumeric(value)) {
            return 'number';
        } else {
            return 'text';
        }
      },
      validateAlphabetOnly(field, model) {
      this[model][field] = this[model][field].replace(/[^a-zA-Z\s]/g, '');
    },

    validateName(field, model) {
      this[model][field] = this[model][field].replace(/[0-9]/g, '');
    },

    validateNumber(field, model) {
      this[model][field] = this[model][field].replace(/\D/g, '');
    },

    validateMobileNumber(field, model) {
      this[model][field] = this[model][field].replace(/\D/g, '').slice(0, 10);
    },

    validateTelephoneNumber(field, model) {
      this[model][field] = this[model][field].replace(/\D/g, '').slice(0, 7);
    },
    },
  };
  </script>