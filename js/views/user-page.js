var app = app || {};

app.UserPageView = Backbone.View.extend({
    children : {},
    id : "user-page",
    template : _.template(app.Templates["user-page"]),

    initialize: function() {
        this.children.userListView = new app.UserListView();
    },

    events : {
    	"click #add-a-user-text" : "toggleInput",
    	"click #add-a-user-close" : "toggleInput",
        "keypress #add-a-user-form input" : "addUser"
    },

    addUser : function(e){
        if((e.keycode || e.which) == 13){
            e.preventDefault();
            var email = $("#add-a-user-form input").val();
            if(email == "")
                return;
            this.children.userListView.collection.create({email : email});
            //this.toggleInput(e);
            $("#add-a-user-form input").val("Email");
        }
    },

    toggleInput : function(e){
        console.log("asdf");
        e.preventDefault();
    	$("#add-a-user-text").toggle();
    	$("#add-a-user-form").toggle();
        if($("#add-a-user-form").is(":visible"))
            $("#add-a-user-form input").focus();
    },

    render : function(){
        this.$el.html(this.template());
        this.$el.append(this.children.userListView.$el)
    }
});