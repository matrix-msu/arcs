# collections.coffee
# ------------------
class arcs.views.SingleProject extends Backbone.View

  initialize: (options) ->
    _.extend @options, _.pick(options, 'model', 'collection', 'el')

  console.log('coffee working!')

  render: () ->
    #console.log('collection:')
    #console.log(@collection)

    console.log('collection.json:')
    fullCollectionList = @collection.toJSON()
    console.log(fullCollectionList)

    @$el.html arcs.tmpl 'collections/list',
      collections: fullCollectionList
    @