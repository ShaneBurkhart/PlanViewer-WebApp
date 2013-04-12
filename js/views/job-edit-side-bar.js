var app = app || {};

app.JobEditSideBarView = Backbone.View.extend({
    children : {},
    id : "job-edit-side-bar",
    template : _.template(app.Templates["job-edit-side-bar"]),

	initialize: function() {
    },

    events : {
        "click #add-a-page-button" : "addPage",
        "keypress #pagename" : "addPageKey"
    },


    addPageKey : function(e){
        if((e.keycode || e.which) == 13)
            this.addPage(e);
        
    },

    addPage : function(e){
        e.preventDefault();
        var pagename = this.$el.find("#pagename").val();
        if(!pagename)
            return;
        this.options.parentView.addPage(pagename);
        this.$el.find("#pagename").val("");
    },

    render : function(){
        this.$el.html(this.template());
        return this;
    }
});