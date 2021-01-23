<template>
  <div class="row">
    <div class="col">
      <table class="table table-striped table-hover">
        <thead class="thead-dark">
          <tr>
            <th>key</th>
            <th>value</th>
            <th style="width: 10%"></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in items">
            <td>{{ item.name }}</td>
            <td>{{ item.value }}</td>
            <td class="text-right">
              <button v-on:click="remove(item)" type="button" class="btn btn-danger">X</button>
            </td>
          </tr>
          <tr>
            <td><input v-model="newKey" type="text" /></td>
            <td><input v-model="newValue" type="text" /></td>
            <td>
              <button v-on:click="add" type="button" class="btn btn-info" :disabled="!newKey || !newValue">ADD</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  props: ['items'],
  name: "KeyValueTable",
  data() {
    return {
      newKey: '',
      newValue: '',
    }
  },
  methods: {
    add: function () {
      this.items.push({'name': this.newKey, 'value': this.newValue})
      this.newKey = ''
      this.newValue = ''
    },
    remove: function (item) {
      this.items = this.items.filter(i => i !== item)
    }
  }
}
</script>

<style scoped>

</style>