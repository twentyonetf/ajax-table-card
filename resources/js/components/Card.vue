<template>

    <card class="flex flex-col h-auto" v-if="cardShown">

        <div class="flex flex-wrap">

            <div class="w-5/6">

                <h1 class="py-6 text-90 font-normal text-2xl text-left pl-4">
                    {{ title }}
                    <span class="text-sm text-primary" v-if="countable">({{ rows.length }})</span>
                    <span class="text-xs text-primary block mt-2">Cached since: {{ since }}</span>
                </h1>

            </div>

            <div class="flex w-1/6 text-center">

                <a class="w-full cursor-pointer py-6 px-4 text-primary"
                   @click="fetchFreshData"
                   title="Refresh Data">

                    <icon type="refresh"
                          width="22"
                          height="18"
                          view-box="0 0 22 22" />

                </a>

            </div>

        </div>

        <loading-view :loading="loading">

            <div v-if="expanded" class="overflow-hidden overflow-x-auto relative">

                <table
                    class="table w-full">
                    <thead v-if="header && header.length > 0">
                    <tr>
                        <th v-for="(head, index) in header" :key="index" class="text-center" :id="index">
              <span class="whitespace-no-wrap">
                {{ head }}
              </span>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(row, index) in rows" :key="index">
                        <td v-for="(value, index) in row" class="text-center">
                            <span v-if="linkable && (index === Object.keys(row).length - 1)">
                              <router-link
                                  class="cursor-pointer text-70 hover:text-primary mr-3"
                                  :to="value"
                                  :title="__('View')">
                                        <icon type="view" width="22" height="18" view-box="0 0 22 16" />
                                      </router-link>
                            </span>
                            <span class="whitespace-no-wrap" v-else>
                            {{ value }}
                            </span>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <div class="text-center">

                    <button class="text-xs text-primary" @click="expanded = false">Click Here to Hide</button>

                </div>

            </div>

            <div class="text-center" v-else>

                <button class="text-xs text-primary" @click="expanded = true">Click Here to Expand</button>

            </div>

            <div class="bg-20 rounded-b-lg flex justify-between">
                <div></div>

                <div>
                    <a class="btn btn-link py-3 px-4 text-80 cursor-pointer" @click="fetchFreshData">Click Here to Refresh</a>
                </div>

            </div>

        </loading-view>
    </card>

</template>

<script>
export default {

    props: ['card'],

    data() {

        return {
            title: this.card.title,
            cache: this.card.cache,
            slug: this.card.slug,
            link: this.card.link,
            header: this.card.header,
            linkable: this.card.linkable,
            expanded: this.card.expanded,
            countable: this.card.countable,
            hideWhenEmpty: this.card.hideWhenEmpty,
            rows: [],
            since: null,
            loading: true,
        }

    },

    mounted() {

        this.fetchCachedData();

    },

    methods: {


        fetchCachedData() {

            this.loading = true;


            Nova.request().get('/nova-vendor/ajax-table-card/cache/' + this.slug)
                .then(({data}) => {
                    this.rows = data.rows;
                    this.since = data.since
                    this.loading = false;

                    if (data.length === 0) {

                        this.fetchFreshData();

                    }

                }).catch(() => {
                this.$toasted.show('Something went wrong fetching data!', {type: 'error'});
            });
        },

        fetchFreshData() {

            this.loading = true;

            Nova.request()
                .get(this.link)
                .then(({data}) => {
                    this.rows = data;
                    this.loading = false;

                    Nova.request().post('/nova-vendor/ajax-table-card/cache', {
                        'data': data,
                        'slug': this.slug,
                        'cache': this.cache
                    }).then(({data}) => {
                        this.since = data;
                    }).catch(() => {
                        this.$toasted.show('Something went wrong caching data!', {type: 'error'});
                    });

                }).catch(() => {

                this.$toasted.show('Something went wrong fetching fresh data!', {type: 'error'});

            });



        }
    },

    computed: {

        cardShown: function () {

            if (this.hideWhenEmpty) {
                return this.rows.length > 0
            } else {
                return true;
            }

        }

    }
}
</script>
