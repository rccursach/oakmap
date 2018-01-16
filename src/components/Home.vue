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
              <label class="label" aria-label="Enabler">Enabler <i class="links-icons is-clickable fa fa-info" v-on:click.prevent="showEnablerModal()" ></i></label>
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
            <div class="modal" id="enablers-info">
              <div class="modal-background"></div>
              <div class="modal-content has-text-white">
                  <p class="is-size-3">Enablers can be viewed with the following lenses:</p>
                  <br/>
                  <ul>
                    <li>PERSONAL enablers (mentors, education, etc.)</li>
                    <li>FINANCIAL enablers (banks, investors, micro-finance, etc.)</li>
                    <li>BUSINESS enablers (incubators, networking associations, etc.)</li>
                    <li>ENVIRONMENT enablers (regulatory framework, infrastructure, culture, etc.)</li>
                  </ul>
                  <button class="button is-pulled-right is-primary is-outlined is-rounded" v-on:click.prevent="closeModal">Ok</button>
              </div>
              <br/>
              <button class="modal-close is-large" aria-label="close" v-on:click.prevent="closeModal"></button>
            </div>  

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
          
          <div>
            <bars
              :padding="20"
              :data="[1, 10, 3, 5, 8, 12, 5]"
              :gradient="['#ffbe88', '#ff93df']"
              :barWidth="20"
              :growDuration="1">
            </bars>
          </div>

          <h2 class="title is-4">Matching Providers <span class="cards-match">{{cards}}</span></h2>
         
          <div class="columns is-multiline is-3 is-mobile">
            <div class="column is-flex-item is-one-fourth-desktop is-one-third-tablet is-half-mobile"
              v-for="dat in mapData" :key="dat.id" v-show="!dat.hide"
            >
              <div class="card is-clickable"  v-on:click="toggleActive" >
                <div class="list-providers">
                  <div v-for="et in dat.enablerType" v-bind:key="et+dat.id" :class="'enabler-dot '+( et != null ? enClasses[et] : '')"></div>
                </div>
                <div class="card-header">
                  <div class="media-content">
                    <p class="title is-5">{{ dat.name }}</p>
                    <p class="subtitle is-7 is-capitalized">
                      {{ dat.category }}
                      {{ (dat.subcategory ? ': '+dat.subcategory : '') | truncate(50) }}
                    </p>
                  </div>
                </div>
                <div class="card-content">
                  {{ dat.about | truncate(60) }}
                </div>
                <footer :class="'card-footer'">
                  <div>
                    <span>
                      <a target="_blank" v-if="!!dat.website" :href="dat.website"><i class="links-icons fa fa-globe"></i></a>
                      <a target="_blank" v-if="!!dat.twitter" :href="'https://twitter.com/'+dat.twitter"><i class="links-icons fa fa-twitter"></i></a>
                      <a target="_blank" v-if="!!dat.address" :href="'https://www.google.com/maps/search/?api=1&query='+encodeURIComponent(dat.address)"><i class="links-icons fa fa-map"></i></a>
                      &nbsp;
                      <span v-if="!!dat.yearsInOakland" class="is-size-7 has-text-right">
                        <!-- there are two spans because of weird data as long text in some objects -->
                        <span v-if="isNaN(dat.yearsInOakland)">
                          {{ dat.yearsInOakland | truncate(10) }} Years in Oakland
                        </span>
                        <span v-if="!isNaN(dat.yearsInOakland)">
                          {{ dat.yearsInOakland }} Years in Oakland
                        </span>
                      </span>
                    </span>
                  </div>
                </footer>
              </div> <!-- end card -->
              <!-- start modal-->
              <div class="modal is-details-modal">
                <div class="modal-background"></div>
                <div class="modal-card">
                  <header class="modal-card-head">
                    <p class="modal-card-title">{{ dat.name }}</p>
                    <button class="delete is-modal-close" aria-label="close" v-on:click="closeModal"></button>
                  </header>
                  <section class="modal-card-body">
                    <p class="subtitle is-7 is-capitalized">
                      {{ dat.category }}
                      <br/>
                      {{ dat.subcategory || '' }}
                      <br/>
                      {{ dat.enablerType ? dat.enablerType.join(', ') : '' }}
                    </p>
                    <hr/>
                    {{ dat.about || '. . .'}}
                    <p>
                      <br>
                      {{ dat.yearsInOakland || '?' }} years in Oakland
                    </p>
                  </section>
                  <footer class="modal-card-foot">
                      <a target="_blank" v-if="!!dat.website" :href="dat.website"><i class="links-icons fa fa-globe"></i> Website</a>
                      <a target="_blank" v-if="!!dat.twitter" :href="'https://twitter.com/'+dat.twitter"><i class="links-icons fa fa-twitter"></i> Twitter</a>
                      <a target="_blank" v-if="!!dat.address" :href="'https://www.google.com/maps/search/?api=1&query='+encodeURIComponent(dat.address)"><i class="links-icons fa fa-map"></i> Address</a>
                  </footer>
                </div>
                <!-- <button class="modal-close is-large" aria-label="close" v-on:click.prevent="closeModal"></button> -->
              </div>
              <!-- end modal -->
            </div>
            <!-- end column v-for -->
          </div> <!-- end columns-multi -->
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
        personal: 'en-purple',
        financial: 'en-red',
        business: 'en-blue',
        environmental: 'en-green'
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
    },
    showEnablerModal () {
      document.querySelector('#enablers-info').classList.add('is-active')
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
    },
    closeModal (event) {
      event.preventDefault()
      // iterate trough at least 5 levels deep
      var el = event.currentTarget
      for (var i = 0; i < 5; i++) {
        if (el.classList.contains('is-active')) {
          el.classList.remove('is-active')
          break
        }
        el = el.parentNode
      }
    },
    toggleActive (event) {
      event.preventDefault()
      var el = event.currentTarget
      var modal = el.parentNode.querySelector('.is-details-modal')

      if (modal.classList.contains('is-active')) {
        modal.classList.remove('is-active')
      } else {
        this.deactivateAll()
        modal.classList.add('is-active')
      }
    },
    deactivateAll () {
      var els = document.querySelectorAll('.is-details-modal')
      console.log(els)
      els.forEach(function (el) {
        if (el.classList.contains('is-active')) {
          el.classList.remove('is-active')
        }
      })
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
.modal-card-foot a {
  padding-right: 1.3em;
}
.links-icons {
  color: gray;
  padding-right: 0.5em;
}
.links-icons:hover {
  color: rgb(86, 86, 230);
}
.is-flex-item .card {
  height: 100%;
}
.media-content {
  padding: 1em;
  overflow: hidden;
}
.media-content .subtitle {
  padding-top: 0.5rem;
}

/* this two fix the footer at the end of the card */
.card .card-content {
  padding: 1em;
  margin-bottom: 2em;
}
.card > footer {
  position: absolute;
  bottom: 0;
  width: 100%;
  padding: 0.4em 1em 0.4em 1em;
}
/* -- */

.list-providers {
  height: 0.3em;
  background-color: rgb(220, 220, 220);
}
.enabler-dot {
  height: 100%;
  min-width: 25%;
  float: left;
}
.en-purple {
  background-color: rgb(204, 149, 255);
}
.en-green {
  background-color: rgb(147, 225, 191);
}
.en-red {
  background-color: rgb(254, 143, 143);
}
.en-blue {
  background-color: rgb(151, 191, 255);
}

/* -- */
.cards-match {
  color: rgb(39, 189, 194);
}

/* styles for grid expansion*/
.is-clickable {
  cursor: pointer;
}

.modal-card-title {
  overflow-wrap: break-word;
}

.is-modal-close {
  position: absolute;
  right: 1rem;
  top: 1rem;
}
.modal-card-body {
  min-height: 8em;
}
/* this fixes long titles */
p.modal-card-title {
  width: 95%;
}
</style>
