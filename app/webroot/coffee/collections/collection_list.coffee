# collection_list.coffee
# ----------------------
class arcs.collections.CollectionList extends Backbone.Collection
  model: arcs.models.Collection
  
  initialize: () ->
    this.sortVar = 'created'
    
  comparator: (resource) ->
    resource.get this.sortVar


