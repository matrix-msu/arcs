# flags.coffee
# ------------
# Manage flags.
arcs.views.admin ?= {}
class arcs.views.admin.Flags extends Backbone.View

  initialize: (options) ->
    _.extend @options, _.pick(options, 'el', 'collection')
    @collection.on 'add remove change sync', @render, @
    @render()

  render: ->
    @$('#flags').html arcs.tmpl 'admin/flags', 
      flags: @collection.toJSON()
    @
