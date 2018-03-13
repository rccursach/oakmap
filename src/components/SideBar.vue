<template>
  <div>
    <div v-if="item.type === 'pro'">
      <h2 class="is-size-4">{{ item.programName || 'Program' }}</h2>
      <p>{{ item.programType }}</p>
      <p>By {{ item.stakeholderName || 'Unknown' }}</p>
      <hr>
      <p>{{ item.description }}</p>
    </div>
    
    <div v-if="item.type === 'sh'">
      <h2 class="is-size-4">{{ item.name }}</h2>
      <p>{{ item.description || item.programType }}</p>
    </div>
    
    <div v-if="item.type === 'sht'">
      <h2 class="is-size-4">{{ item.name }}</h2>
    </div>

    <div v-if="item === {}">
      <p>Please select a node ...</p>
    </div>

  </div>
</template>
<script>
import { EventBus } from '../event-bus.js'

export default {
  name: 'sideBar',
  props: {
  },
  data () {
    return {
      item: {}
    }
  },
  methods: {
    //
  },
  created () {
    const vm = this
    EventBus.$on('clicked-node', function (i) {
      vm.item = i
      console.log(i)
    })
  },
  mounted () {
    //
  },
  watch: {
  }
}
</script>
<style lang="scss">

</style>


