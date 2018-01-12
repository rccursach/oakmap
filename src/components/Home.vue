<template>
  <div>
    <!--  -->
    <div class="container">
      <div class="columns">
        
        <div class="column is-one-quarter">            
          <form class="form">
            <h4 class="title is-4">Find a good fit:</h4>

            <div class="field" aria-label="Search">
              <div class="control has-icons-left">
                <input class="input" type="text" id="search_name" placeholder="Search...">
                <span class="icon is-small is-left">
                  <i class="fa fa-search"></i>
                </span>
              </div>
            </div>

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
              <label class="label" aria-label="Enabler">Enabler <i class="grey icon help" id="help_enabler" v-on:click="showEnablerModal()" ></i></label>
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

            <!-- <div class="ui basic modal">
              <div class="ui icon header">
                <i class="archive icon"></i>
                Enablers
              </div>
              <div class="content">
                <h1 class="header">Enablers can be viewed with the following lenses:</h1>
                <div class="ui huge middle aligned animated list">
                  <div class="item">PERSONAL enablers (mentors, education, etc.)</div>
                  <div class="item">FINANCIAL enablers (banks, investors, micro-finance, etc.)</div>
                  <div class="item">BUSINESS enablers (incubators, networking associations, etc.)</div>
                  <div class="item">ENVIRONMENT enablers (regulatory framework, infrastructure, culture, etc.)</div>
                </div>
              </div>
              <div class="actions">
                <div class="ui green ok inverted button">
                  <i class="checkmark icon"></i>
                  OK
                </div>
              </div>
            </div> -->

            <div class="field">
              <button class="button is-primary is-outlined is-rounded" id="search_button" v-on:click.prevent="filterCards()">Find a Fit</button>
            </div>
          </form>
            <!--
            <div class="ui vertical menu">
            <div class="item">
              <div class="header">Products</div>
              <div class="menu">
                <a class="item">Enterprise</a>
                <a class="item">Consumer</a>
              </div>
            </div>
            </div>
            -->
        </div>
        
        <div class="column">
          
          <!-- <div class="container">
            <bars
              :data="[1, 10, 3, 5, 8, 12, 5]"
              :gradient="['#ffbe88', '#ff93df']"
              :barWidth="40"
              :growDuration="1">
            </bars>
          </div> -->

          <h2 class="title is-4">Matching Providers <span id="match_count" class="ui teal header">{{cards}}</span></h2>
         
          <div class="columns flex-row">
            <div class="actor column is-one-third" v-for="dat in mapData" :key="dat.id" v-show="!dat.hide">
              <div
                :class="'card ixs-3' + dat.enablerType.map(function (e) { return enClasses[e] }).join(' ')"
                :data-name="dat.name | lowercase"
                :data-target="dat.target | lowercase"
                :data-stage="dat.stage ? dat.stage.join(' ') : '' | lowercase"
                :data-category="dat.category ? dat.category.replace(' ', '') : '' | lowercase"
                :data-enabler="dat.enablerType ? dat.enablerType.join(' ') : '' | lowercase"
              >
                <header class="card-header">
                  <p class="card-header-title">{{ dat.name }}</p>
                </header>

                <div class="card-content">
                  <div class="content">
                      <span class="category is-size-7">
                        {{ dat.category | capitalize | truncate(20)}}, {{ (dat.subcategory ? ': '+dat.subcategory : '') | capitalize | truncate(20)}}
                      </span>
                      <br>
                      {{ dat.about | truncate(30) }}
                  </div>
                </div>
                <div class="card-footer">
                  &nbsp;
                  <span v-if="!!dat.yearsInOakland" class="right floated">
                    {{ dat.yearsInOakland }} Years in Oakland
                  </span>
                  <span>
                    <a v-if="!!dat.website" :href="dat.website"><i class="fa fa-globe"></i></a>
                    <a v-if="!!dat.twitter" :href="'https://twitter.com/'+dat.twitter"><i class="fa fa-twitter"></i></a>
                    <a v-if="!!dat.address" :href="'https://www.google.com/maps/search/?api=1&query='+encodeURIComponent(dat.address)"><i class="fa fa-map"></i></a>
                  </span>
                </div>
              </div> <!-- end card -->
            </div>
            <!-- end v-for -->
          </div> <!-- end is-flex -->
        </div> <!-- end column -->

      </div><!-- end columns -->
    </div>
    <!--  -->
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'Home',
  data () {
    return {
      mapData: [],
      cards: 0,
      enClasses: {
        personal: 'purple',
        financial: 'red',
        business: 'blue',
        environmental: 'green'
      }
    }
  },
  methods: {
    loadData () {
      axios.get('data/data.oaktown.v1.json').then(
        d => {
          var values = Object.values(d.data)
          this.mapData = values.map(md => {
            md.hide = false
            return md
          })
          window.d = this.mapData
          this.cards = this.mapData.length
        },
        error => {
          console.log(error)
        }
      )
      // window.$.get('data/data.oaktown.v1.json', (d) => {
      //   var values = Object.values(d)
      //   this.mapData = values.map((md) => { md.hide = false; return md })
      //   window.d = this.mapData
      //   this.cards = this.mapData.length
      // })
    },
    showEnablerModal () {
      // window.$('.ui.basic.modal').modal('show')
    },
    countCards () {
      const reducer = (n, o) => n + (o.hide === true ? 1 : 0)
      this.cards = this.mapData.length - this.mapData.reduce(reducer, 0)
    },
    filterCards () {
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
      this.countCards()
      // $('div .card:visible').transition('pulse') // <- this is terrible slow, like 6k msec slow
    }
  },
  created: function () {
    this.loadData()
    // window.$('select.dropdown').dropdown()
    this.cards = this.mapData.length
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.fa {
  color: gray;
}
.fa:hover {
  color: rgb(86, 86, 230);
}
.flex-row {
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
  align-items: stretch;
}
.flex-row .actor {
  display: inline-block;
}
.card-content {
  height: 8em;
  max-height: 8em !important;
  }
</style>
