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
    data: {
      type: Array,
      required: true
    },
    links: {
      type: Array,
      required: true
    }
  },
  data () {
    return {
      nodes: [],
      width: 840,
      height: 510,
      svg: null
    }
  },
  methods: {
    hey (name) {
      alert(name)
    },
    genChart () {
      // const vm = this
      d3.select(this.$el).selectAll('svg').remove()

      this.nodes = this.data.filter(d => !d.hide)

      function ticked () {
        link
        .attr('x1', function (d) { return d.source.x })
        .attr('y1', function (d) { return d.source.y })
        .attr('x2', function (d) { return d.target.x })
        .attr('y2', function (d) { return d.target.y })

        node
        .attr('cx', function (d) { return d.x })
        .attr('cy', function (d) { return d.y })
      }

      function dragstarted (d) {
        if (!d3.event.active) simulation.alphaTarget(0.3).restart()
        d.fx = d.x
        d.fy = d.y
      }

      function dragged (d) {
        d.fx = d3.event.x
        d.fy = d3.event.y
      }

      function dragended (d) {
        if (!d3.event.active) simulation.alphaTarget(0)
        d.fx = null
        d.fy = null
      }

      const svg = d3.select(this.$el)
      .append('svg')
      .attr('width', this.width)
      .attr('height', this.height)

      var simulation = d3.forceSimulation()
      .force('link', d3.forceLink().id(function (d) { return d.id }))
      .force('charge', d3.forceManyBody().strength(-100).distanceMax(50).distanceMin(10))
      .force('center', d3.forceCenter(this.width / 2, this.height / 2))

      var link = svg.append('g')
      .attr('class', 'links')
      .selectAll('line')
      .data(this.links)
      .enter().append('line')
      .attr('stroke-width', '0.5')

      var node = svg.append('g')
      .attr('class', 'circle')
      .selectAll('circle')
      .data(this.data)
      .enter().append('circle')
      .attr('r', function (d) {
        switch (d.type) {
          case 'sht':
            return 20
          case 'sh':
            return 15
          case 'pro':
            return 8
          default:
            return 5
        }
      })
      .attr('fill', function (d) {
        switch (d.type) {
          case 'sht':
            return 'blue'
          case 'sh':
            return 'green'
          case 'pro':
            return 'purple'
          default:
            return 'yellow'
        }
      })
      .on('click', function (d) {
        EventBus.$emit('clicked-node', d)
      })
      .call(d3.drag()
      .on('start', dragstarted)
      .on('drag', dragged)
      .on('end', dragended))

      node.append('title')
      .text(function (d) { return d.name || d.id })

      simulation
      .nodes(this.data)
      .on('tick', ticked)

      simulation.force('link')
      .links(this.links)
    }
  },
  mounted () {
    // this.genChart()
  },
  created: function () {
    EventBus.$on('updated-data', () => {
      console.log('did you filter?')
      this.genChart()
    })
  },
  watch: {
    data: function (newData, oldData) {
      console.log('did i changed?')
      this.genChart()
    }
  }
}
</script>

<style lang="scss" >

.viz {
  background-color: rgba(138, 65, 65, 0.023);
}
.links line {
  stroke: #999;
  stroke-opacity: 0.6;
}
.nodes circle {
  stroke: rgb(0, 0, 0);
  stroke-width: 1.5px;
  &:hover {
    // filter: drop-shadow( -5px -5px 5px #000 );
    fill: red;
  }
}
</style>
