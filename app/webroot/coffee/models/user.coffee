# user.coffee
# -----------
class arcs.models.User extends Backbone.Model
  ROLES:
    'Admin'          : 0
    'Sr. Researcher' : 1
    'Researcher'     : 2
    'Guest'          : 3

  urlRoot: arcs.baseURL + 'users/'

  is: (role) ->
    @get('role') == role

  isLoggedIn: ->
    @id?

  isAdmin: ->
    @get('role') == 'Admin'