var app = app || {};

app.FileListView = Backbone.View.extend({
    children : {},
	el : "#file-list-container",

	initialize: function() {
        this.collection = new app.FileListCollection();
        this.collection.fetch();
        this.render();
        this.listenTo(this.collection, "reset", this.render);
        this.listenTo(this.collection, "change", this.render);
        this.listenTo(this.collection, "add", this.renderOne);
    },

    events : {
    },

    render : function(){
        this.$el.html("");
        this.renderAll();
    },

    renderAll : function(){
        this.collection.each(function(item){
            this.renderOne(item);
        }, this);
    },

    renderOne : function(item){
        var fileView = new app.FileItemView({
            model : item
        });
        this.$el.append(fileView.render().el);
    }
});