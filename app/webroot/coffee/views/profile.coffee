class arcs.views.Profile extends Backbone.View

  events:
    'click #edit-profile': 'editAccount'

  editAccount: ->
    new arcs.views.Modal
      title: 'Edit Your Account'
      subtitle: "If you'd like your password to stay the same, leave the " +
        "password field blank."
      inputs:
        name:
          value: @model.get 'name'
        username:
          value: @model.get 'username'
        email:
          value: @model.get 'email'
        password:
          type: 'password'
      buttons:
        save:
          validate: true
          class: 'btn btn-success'
          callback: (vals) =>
            if vals.password == ''
              delete vals.password
            arcs.loader.show()
            @model.save vals,
              success: (model, response, options) ->
                arcs.loader.hide()
                return
              error: (model, response, options) ->
                arcs.loader.hide() # this is very finicky and returns when the request succeeds
                return
        cancel: ->
