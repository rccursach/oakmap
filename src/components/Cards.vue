<template>

  <div class="columns is-multiline">
    <div class="column is-flex-item is-4 is-one-quarter-desktop is-one-third-tablet xis-half-mobile"
      v-for="dat in mapData" :key="dat.id" v-show="!dat.hide"
    >
      <div class="card is-clickable" v-on:click="toggleActive" v-on:keyup.enter="toggleActive" aria-role="button" tabindex="0" aria-describedby="actor-modal-title">
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
              <span aria-hidden="true">
                <a target="_blank" v-if="!!dat.website" :href="dat.website"><i class="links-icons fa fa-globe"></i></a>
                <a target="_blank" v-if="!!dat.twitter" :href="'https://twitter.com/'+dat.twitter"><i class="links-icons fa fa-twitter"></i></a>
                <a target="_blank" v-if="!!dat.address" :href="'https://www.google.com/maps/search/?api=1&query='+encodeURIComponent(dat.address)"><i class="links-icons fa fa-map"></i></a>
              </span>
              &nbsp;
              <span v-if="!!dat.yearsInOakland" class="is-size-7 has-text-right">
                <!-- there are two spans because of weird data as long text in some objects -->
                <span v-if="isNaN(dat.yearsInOakland)">
                  {{ dat.yearsInOakland | truncate(10) }} Years in Oakland
                </span>
                <span v-if="!isNaN(dat.yearsInOakland)">
                  {{ dat.yearsInOakland }} Years in Oakland
                </span>
                <span aria-label="Press enter to see details"></span>
              </span>
            </span>
          </div>
        </footer>
      </div> <!-- end card -->
      <!-- start modal-->
      <div class="modal is-details-modal" aria-role="dialog" aria-modal="true">
        <div class="modal-background"></div>
        <div class="modal-card" tabindex="0">
          <header class="modal-card-head">
            <p class="modal-card-title">{{ dat.name }}</p>
            <button class="delete is-modal-close" aria-role="buttom" aria-label="close" tabindex="0" v-on:click="closeModal"></button>
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
          <footer class="modal-card-foot" tabindex="0" aria-label="links">
              <a tabindex="0" aria-label="visit website" target="_blank" v-if="!!dat.website" :href="dat.website"><i class="links-icons fa fa-globe"></i> Website</a>
              <a tabindex="0" aria-label="visit twitter" target="_blank" v-if="!!dat.twitter" :href="'https://twitter.com/'+dat.twitter"><i class="links-icons fa fa-twitter"></i> Twitter</a>
              <a tabindex="0" aria-label="find it on maps" target="_blank" v-if="!!dat.address" :href="'https://www.google.com/maps/search/?api=1&query='+encodeURIComponent(dat.address)"><i class="links-icons fa fa-map"></i> Address</a>
          </footer>
        </div>
        <!-- <button class="modal-close is-large" aria-label="close" v-on:click.prevent="closeModal"></button> -->
      </div>
      <!-- end modal -->
    </div>
    <!-- end column v-for -->
  </div> <!-- end columns-multi -->

</template>

<script>
export default {
  name: 'cards',
  props: {
    mapData: {
      type: Array,
      required: true
    }
  },
  data () {
    return {
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
    countCards () {
      const reducer = (n, o) => n + (o.hide === true ? 1 : 0)
      this.cards = this.mapData.length - this.mapData.reduce(reducer, 0)
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
        console.log(document.querySelector('.is-details-modal.is-active > .modal-card'))
        document.querySelector('.is-details-modal.is-active > .modal-card').focus()
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
/* styles for cards */
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
.modal-card-foot a {
  padding-right: 1.3em;
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

/* providers colors */
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

/* styles for grid expansion*/
.is-clickable {
  cursor: pointer;
}

/* styles for modals */
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
