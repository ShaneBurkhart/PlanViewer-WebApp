var app = app || {};

app.JobEditView = Backbone.View.extend({
    children : {},
	el : "#page-container",
    template : _.template(app.Templates["job-edit"]),

	initialize: function() {
        this.model = new app.JobEditModel({id : this.id});
        var self = this;
        this.model.fetch({success : function(){
            self.children.fileListView = new app.FileListView({id : this.id});
        }});
        this.listenTo(this.model, "change", this.render);
    },

    events : {
    },

    render : function(){
        this.$el.html(this.template(this.model.toJSON()));
    }
});