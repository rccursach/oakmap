<template>
  <div class="viz">
  </div>
</template>

<script>
import * as d3 from 'd3'

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
      height: 300
    }
  },
  methods: {
    genChart () {
      // alert('re rendering')
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

      const force = d3.forceSimulation()
      .force('center', d3.forceCenter(this.width / 2, this.height / 2))
      .force('charge', d3.forceManyBody())
      .force('y', d3.forceY(0))
      .force('x', d3.forceX(0))

      function dragstarted (d) {
        if (!d3.event.active) force.alphaTarget(0.3).restart()
        d.fx = d.x
        d.fy = d.y
      }

      function dragged (d) {
        d.fx = d3.event.x
        d.fy = d3.event.y
      }

      function dragended (d) {
        if (!d3.event.active) force.alphaTarget(0)
        d.fx = null
        d.fy = null
      }

      const svg = d3.select(this.$el)
      .append('svg')
      .attr('width', this.width)
      .attr('height', this.height)
      .append('g')
      .attr('transform', 'translate(0, 10)')

      let circles = svg.selectAll('circle').data(this.nodes, function (d) {
        return d.id
      })
      circles.enter().append('circle').data(this.nodes, function (d) {
        return d.id
      }).attr('r', function (d) {
        return d.r
      }).attr('cx', function (d) {
        return d.x
      }).attr('cy', function (d) {
        return d.y
      }).attr('fill', function (d) {
        return `#${d.rgb[0]}${d.rgb[1]}${d.rgb[2]}`
      })
      .call(d3.drag()
      .on('start', dragstarted)
      .on('drag', dragged)
      .on('end', dragended))

      force.nodes(this.nodes)
    }
  },
  mounted () {
    this.genChart()
  },
  created: function () {
    this.genChart()
    this.$on('map-filtered', () => { alert('hey') /* this.genChart() */ })
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
