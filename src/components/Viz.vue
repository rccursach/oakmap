<template>
  <div class="viz">
  </div>
</template>

<script>
import * as d3 from 'd3'
import { EventBus } from '../event-bus.js'

export default {
  name: 'viz',
  props: {
    mapData: {
      type: Array,
      required: true
    }
  },
  data () {
    return {
      nodes: [],
      width: 840,
      height: 300,
      svg: null
    }
  },
  methods: {
    genChart () {
      d3.select(this.$el).selectAll('svg').remove()
      
      this.nodes = this.mapData.filter(d => !d.hide).map(d => {
        return {
          id: d.id,
          name: d.name,
          x: Math.random() * this.width,
          y: Math.random() * this.height,
          r: d.name.length / 2,
          rgb: [
            Math.round(Math.random() * 255).toString(16),
            Math.round(Math.random() * 255).toString(16),
            Math.round(Math.random() * 255).toString(16)
          ]
        }
      })

      const svg = d3.select(this.$el)
      .append('svg')
      .attr('width', this.width)
      .attr('height', this.height)

      svg.selectAll('circle')
      .data(this.nodes)
      .enter()
      .append('circle')
      .attr('r', function (d) {
        return d.r
      }).attr('cx', function (d) {
        return d.x
      }).attr('cy', function (d) {
        return d.y
      }).attr('fill', function (d) {
        return `#${d.rgb[0]}${d.rgb[1]}${d.rgb[2]}`
      })
    }
  },
  mounted () {
    this.genChart()
  },
  created: function () {
    EventBus.$on('updated-data', () => {
      this.genChart()
    })
  }
}
</script>

<style lang="scss" >
.viz {
  background-color: rgba(113, 158, 184, 0.171);
}
svg {
  background-color: rgba(241, 239, 95, 0);
}
circle {
  // fill: rgba(16, 151, 16, 0.953);
  stroke: rgba(0, 0, 0, 0.377);
}
</style>
