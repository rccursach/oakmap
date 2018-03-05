<template>
  <form class="form">
    <!-- search -->
    <portal to="search-form">
      <form v-on:submit.prevent="filterCards()">
        <div class="field">
          <div class="control has-icons-left">
            <input class="input" type="text" tabindex="0" id="search_name" aria-placeholder="Search actor by name" placeholder="Search..." autocomplete="off">
            <span class="icon is-small is-left">
              <i class="fa fa-search"></i>
            </span>
          </div>
        </div>
      </form>
    </portal>
    <!-- <h4 class="title is-4">Find a good fit:</h4> -->
    <div class="field">
      <label class="label" aria-label="Stage">Stage</label>
      <div class="select is-fullwidth">
        <select class="" id="search_stage">
          <option value=""></option>
          <option value="inspire">Inspire</option>
          <option value="plan">Plan</option>
          <option value="launch">Launch</option>
          <option value="sustain">Sustain</option>
          <option value="grow">Grow</option>
          <option value="exit">Exit</option>
        </select>
      </div>
    </div>

    <div class="field">
      <label class="label" aria-label="Target">Target</label>
      <div class="select is-fullwidth">
        <select class="" id="search_target">
          <option value=""></option>
          <option value="small">Small</option>
          <option value="mid">Mid</option>
          <option value="high">High</option>
          <option value="all">All</option>
        </select>
      </div>
    </div>

    <div class="field">
      <label class="label" aria-label="Category">Category</label>
      <div class="select is-fullwidth">
        <select class="" id="search_category">
          <option value=""></option>
          <option value="Educational Institution">Educational Institution</option>
          <option value="Service Provider">Service Provider</option>
          <option value="Investor">Investor</option>
          <option value="Government">Government</option>
          <option value="Lender">Lender</option>
          <option value="Association">Association</option>
          <option value="Foundation">Foundation</option>
        </select>
      </div>
    </div>

    <div class="field">
      <label class="label" aria-label="Enabler">Enabler</label>
      <div class="select is-fullwidth">
        <select class="" id="search_enabler">
          <option value=""></option>
          <option value="personal">Personal</option>
          <option value="financial">Financial</option>
          <option value="business">Business</option>
          <option value="environment">Environment</option>
        </select>
      </div>
    </div>
    <div class="field">
      <button class="button is-primary is-outlined is-rounded" id="search_button" v-on:click.prevent="filterCards()">Find a Fit</button>
    </div>
  </form>
</template>
<script>
export default {
  name: 'filterForm',
  props: {
    mapData: {
      type: Array,
      required: true
    }
  },
  data () {
    return {
      cards: 0
    }
  },
  methods: {
    countCards () {
      const reducer = (n, o) => n + (o.hide === true ? 1 : 0)
      this.cards = this.mapData.length - this.mapData.reduce(reducer, 0)
    },
    filterCards () {
      // document.querySelector('#nlf').classList.remove('is-active')
      // set variables
      var filters = []
      filters.name = document.querySelector('#search_name').value.toLowerCase()
      filters.stage = document
        .querySelector('#search_stage')
        .value.toLowerCase()
      filters.target = document
        .querySelector('#search_target')
        .value.toLowerCase()
      filters.category = document
        .querySelector('#search_category')
        .value.toLowerCase()
      filters.enablerType = document
        .querySelector('#search_enabler')
        .value.toLowerCase()

      // filter out empty filters, get filter keys
      var fks = Object.keys(filters).filter(function (f) {
        return filters[f] !== ''
      })
      // for each object
      this.mapData.forEach(function (d) {
        d.hide = false
        // for eack search key
        fks.some(function (fk) {
          // Use .some to break immediately when d.hide === true
          if (d[fk] && ['stage', 'enablerType'].includes(fk)) {
            // if key is one of those
            if (
              !d[fk]
                .join('')
                .toLowerCase()
                .includes(filters[fk].toLowerCase())
            ) {
              // when the property exists and val != searched val
              d.hide = true
            }
          } else if (fk === 'name') {
            // key is 'name', then val don't match substring searched
            if (!d[fk].toLowerCase().includes(filters[fk].toLowerCase())) {
              d.hide = true
            }
          } else if (
            d[fk] &&
            d[fk].toLowerCase() !== filters[fk].toLowerCase()
          ) {
            // any other key and direct values don't match
            d.hide = true
          } else if (!d[fk]) {
            // there is no key
            d.hide = true
          }
          return d.hide // break .some if hide === true
        })
      })
      // update count of cards
      // this.countCards()

      this.$emit('map-filtered', 'ok')

      // focus oin results banner (for screen readers)
      var searchRes = document.querySelector('#matched-providers')
      searchRes.focus()
    }
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

<style lang="scss" scoped>

</style>