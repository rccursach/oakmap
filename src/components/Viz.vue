<template>
  <div class="viz">
    <!--  -->
    Here viz #{{ cards }}
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
      cards: 0,
      myData: [99, 71, 78, 25, 36, 92]
    }
  },
  methods: {
    loadData () {
      let a = d3
      return a
    },
    countCards () {
      const reducer = (n, o) => n + (o.hide === true ? 1 : 0)
      this.cards = this.mapData.length - this.mapData.reduce(reducer, 0)
    }
  },
  mounted() {
    const svg = d3.select(this.$el)
      .append('svg')
      .attr('width', 500)
      .attr('height', 270)
      .append('g')
      .attr('transform', 'translate(0, 10)');
    const x = d3.scaleLinear().range([0, 430]);
    const y = d3.scaleLinear().range([210, 0]);
    d3.axisLeft().scale(x);
    d3.axisTop().scale(y);
    x.domain(d3.extent(this.myData, (d, i) => i));
    y.domain([0, d3.max(this.myData, d => d)]);
    const createPath = d3.line()
      .x((d, i) => x(i))
      .y(d => y(d));
    svg.append('path').attr('d', createPath(this.myData));
  },
  watch: {
    mapData: function (newMapData, oldMapData) {
      this.mapData = newMapData
      this.countCards()
    }
  },
  created: function () {
    this.countCards()
  }
}
</script>

<style lang="scss" >
svg {
  margin: 25px;
  path {
    fill: none;
    stroke: #76BF8A;
    stroke-width: 3px;
  }
}
</style>
