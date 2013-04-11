var app = app || {};

app.FileListView = Backbone.View.extend({
    children : {},
    tagName : "ul",
	id : "file-list-container",
    className : "unstyled list-view",

	initialize: function() {
        this.collection = new app.FileListCollection(0, {url : "api/file/" + this.options.jobId});
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
        console.log(item);
        var fileView = new app.FileItemView({
            model : item
        });
        this.$el.append(fileView.render().el);
    }
});