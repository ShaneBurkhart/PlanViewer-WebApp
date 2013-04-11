var app = app || {};

app.JobPageView = Backbone.View.extend({
    children : {},
    id : "job-page",
    tagName : "div",
    template : _.template(app.Templates["job-page"]),

    initialize: function() {
        this.children.jobListView = new app.JobListView({parent : this});
    },

    events : {
        "click #add-a-job-text" : "toggleInput",
        "click #add-a-job-close" : "toggleInput",
        "keypress #add-a-job-form input" : "addJob"
    },

    addJob : function(e){
        if((e.keycode || e.which) == 13){
            e.preventDefault();
            var name = $("#add-a-job-form input").val();
            if(name == "")
                return;
            this.children.jobListView.collection.create({name : name});
            this.toggleInput(e);
            $("#add-a-job-form input").val("");
        }
    },

    toggleInput : function(e){
        e.preventDefault();
    	$("#add-a-job-text").toggle();
    	$("#add-a-job-form").toggle();
        if($("#add-a-job-form").is(":visible"))
            $("#add-a-job-form input").focus();
    },

    render : function(){
        this.$el.html(this.template());
        this.$el.append(this.children.jobListView.$el);
    }
});