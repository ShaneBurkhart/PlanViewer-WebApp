var app = app || {};

app.UserListView = Backbone.View.extend({
    id : "user-list-container",
    tagName : "ul",
    className : "unstyled list-view",

    children : {},

	initialize: function() {
        this.collection = new app.UserListCollection();
        this.collection.fetch();
        this.listenTo(this.collection, "add", this.render);
        this.listenTo(this.collection, "reset", this.render);
        this.listenTo(this.collection, "change", this.render);
    },

    render : function(){
        this.$el.html("");
        this.renderAll();
        return this;
    },

    renderAll : function(){
    	this.collection.each(function(item){
    		this.renderOne(item);
    	}, this);
    },

    renderOne : function(item){
    	var userView = new app.UserItemView({
    		model : item
    	});
    	this.$el.append(userView.render().el);
    }
});