var app = app || {};

app.JobListView = Backbone.View.extend({
    children : {},
    id : "job-list-container",
    tagName : "ul",
    className : "unstyled list-view",

	initialize: function() {
        this.collection = new app.JobListCollection();
        this.collection.fetch();

        this.listenTo(this.collection, "add", this.renderOne);
        this.listenTo(this.collection, "reset", this.render);
        this.listenTo(this.collection, "change", this.render);
    },

    render : function(){
        this.$el.html("");
        this.renderAll();
        return this;
    },

    renderAll : function(){
    	this.collection.each(this.renderOne, this);
    },

    renderOne : function(item){
    	var jobView = new app.JobItemView({
    		model : item
    	});
    	this.$el.append(jobView.render().el);
    }
});