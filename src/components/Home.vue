<template>
  <div>
    <!--  -->
    <div class="container">
    <div class="up-button is-hidden-desktop " v-on:click.prevent="scrollToTop">
      <i class="fa fa-arrow-up"></i>
    </div>
      <!-- search -->
      <portal to="search-form">
        <form v-on:submit.prevent="filterCards()">
          <div class="field" aria-label="Search">
            <div class="control has-icons-left">
              <input class="input" type="text" id="search_name" placeholder="Search..." autocomplete="off">
              <span class="icon is-small is-left">
                <i class="fa fa-search"></i>
              </span>
            </div>
          </div>
        </form>
      </portal>
      <!--  -->
      <!-- enablers modal -->
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
      <!-- ends enablers modal -->

      <!-- modal natural language form -->
      <div class="modal" id="nlf">
        <div class="modal-background"></div>
        <div class="modal-content">
          <div class="tile is-ancestor is-padded">
            <div class="tile is-vertical">
              <div class="tile">
                <article class="tile is-child notification is-primary is-padded">
                  <div class="title">Find a good fit:</div>
                  <!-- <p class="subtitle">Asdfgh sdfgh er dfg</p> -->
                  <form>
                    <div class="content is-size-3-desktop is-size-5-mobile">
                      I'm looking for 
                      <div class="nlf-item-box">
                        <select class="nlf-select-item has-text-light is-size-3-desktop is-size-5-mobile has-text-weight-light" aria-placeholder="category" id="search_category">
                          <option value="">any institution</option>
                          <option value="Educational Institution">an educational institution</option>
                          <option value="Service Provider">a service provider</option>
                          <option value="Investor">an investor</option>
                          <option value="Government">a government office</option>
                          <option value="Lender">a lender</option>
                          <option value="Association">an association</option>
                          <option value="Foundation">a foundation</option>
                        </select>
                      </div>
                      offering 
                      <!-- <i class="links-icons is-super is-clickable is-size-6 fa fa-question" v-on:click.prevent="showEnablerModal()"></i> -->
                      <div class="nlf-item-box">
                        <select class="nlf-select-item has-text-light is-size-3-desktop is-size-5-mobile has-text-weight-light" aria-placeholder="enabler" id="search_enabler">
                          <option value="">any</option>
                          <option value="personal">personal</option>
                          <option value="financial">financial</option>
                          <option value="business">business</option>
                          <option value="environment">environment</option>
                        </select>
                      </div>
                      help to people at 
                      <div class="nlf-item-box">
                        <select class="nlf-select-item has-text-light is-size-3-desktop is-size-5-mobile has-text-weight-light has-text-centered" aria-placeholder="stage" id="search_stage">
                            <option value="">any</option>
                            <option value="inspire">inspire</option>
                            <option value="plan">plan</option>
                            <option value="launch">launch</option>
                            <option value="sustain">sustain</option>
                            <option value="grow">grow</option>
                            <option value="exit">exit</option>
                        </select>
                      </div>
                        stage, targeting 
                      <div class="nlf-item-box">
                        <select class="nlf-select-item has-text-light is-size-3-desktop is-size-5-mobile has-text-weight-light" aria-placeholder="stage" id="search_target">
                          <option value="">any</option>
                          <option value="small">small</option>
                          <option value="mid">mid</option>
                          <option value="high">high</option>
                          <option value="all">all</option>
                        </select>
                      </div>
                      size business.
                    </div>
                    <div>
                      <button class="button is-info xis-outlined is-rounded is-pulled-right-desktop" id="search_button" v-on:click.prevent="filterCards()">Go</button>
                    </div>
                  </form>
                </article>
              </div>
            </div>
          </div>

        </div>
        <button class="modal-close is-large" aria-label="close" v-on:click.prevent="closeModal"></button>
      </div>
      <!--  -->
      <div class="columns" id="main-container">
        <div class="column">
          
          <div class="is-hidden">
            <bars
              :padding="20"
              :data="[1, 5, 3, 5, 7, 2, 5]"
              :gradient="['#ffbe88', '#ff93df']"
              :barWidth="20"
              :growDuration="1">
            </bars>
          </div>

          <div class="columns">
            <div class="column is-banner">
              <h2 class="title is-size-4 has-text-white">Matching Providers <span class="xcards-match">{{cards}} </span></h2>
              <button class="button is-rounded is-info xis-outlined" v-on:click.prevent="showNlf">Find a fit</button>
            </div>
          </div>
         
          <div class="columns is-multiline">
            <div class="column is-flex-item is-4 is-one-quarter-desktop is-one-third-tablet xis-half-mobile"
              v-for="dat in mapData" :key="dat.id" v-show="!dat.hide"
            >
              <div class="card is-clickable"  v-on:click="toggleActive" >
                <div class="list-providers">
                  <div v-for="et in dat.enablerType" v-bind:key="et+dat.id" :class="'enabler-dot '+( et != null ? enClasses[et] : '')"></div>
                </div>
                <div class="card-header">
                  <div class="media-content">
                    <p class="title is-size-5">{{ dat.name }}</p>
                    <p class="subtitle is-size-7 is-capitalized">
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
    scrollToTop () {
      window.scrollTo(0, 0)
    },
    showNlf () {
      document.querySelector('#nlf').classList.add('is-active')
    },
    showEnablerModal () {
      document.querySelector('#enablers-info').classList.add('is-active')
    },
    countCards () {
      const reducer = (n, o) => n + (o.hide === true ? 1 : 0)
      this.cards = this.mapData.length - this.mapData.reduce(reducer, 0)
    },
    filterCards () {
      document.querySelector('#nlf').classList.remove('is-active')
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
.is-super {
  vertical-align: super;
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
/* .cards-match {
  color: rgb(39, 189, 194);
} */

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

.nlf-select-item {
  display: inline;
  appearance: none;
  min-width: 1rem;
  border: 0;
  background-color: inherit;
  /* text-shadow: 1px 1px 3px rgba(150, 150, 150, 0.8); */
}

.nlf-item-box {
  display: inline-block;
  margin: 0;
  -webkit-box-shadow: 0px 1.5px 0px 0px rgba(255, 255, 255, 1);
  -moz-box-shadow:    0px 1.5px 0px 0px rgba(255, 255, 255, 1);
  box-shadow:         0px 1.5px 0px 0px rgba(255, 255, 255, 1);
}

.is-padded {
  padding: 2em 2em 1.5em 2em;
}

.is-banner {
  background: linear-gradient(41deg, #ec95c8 0%, #dfa8bb 31%, #ffbe88 75%);
  /* background: linear-gradient(141deg, #50c2c0 0%, #ff9e88 51%, #ff93df 75%); */
  /* background: linear-gradient(141deg, #ff93df 0%, #ff9e88 51%, #50c2c0 75%); */
  /* background: linear-gradient(141deg, #0fb883 0%, #1fdbc8 51%, #2ce5e8 75%); */
  margin: 3em 0.8em 1.5em 0.8em;
}

.up-button {
  cursor: pointer;
  display: block;
  position: fixed;
  z-index: 100;
  right: 1em;
  bottom: 2em;
  height: 3em;
  width: 3em;
  border-radius: 1.5em;
  text-align: center;
  background-color: #d25ca133;
  color: #d25ca199;
  /* border: 1px solid #d25ca199; */
}
.up-button:hover {
  border: 0;
  background-color: #d25ca199;
  color: white;
}

.modal {
  z-index: 101;
}

#main-container {
  padding: 0 0.5em
}
</style>
