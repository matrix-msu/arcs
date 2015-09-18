# user.coffee
# -----------
class arcs.models.User extends Backbone.Model
  # ROLES is no longer needed.  
  ROLES:
    'Admin'          : 0
    'Moderator'      : 1
    'Researcher'     : 2

  urlRoot: arcs.baseURL + 'users/'

  is: (role) ->
    @get('role') == role

  isLoggedIn: ->
    @id?

  isAdmin: ->
    @get('role') == 'Admin'