var app = app || {};

Backbone.View.prototype.close = function(){
	this.remove();
	this.unbind();
	if(this.onClose)
		this.onClose();
}

app.RegionManager = {

	el : "#page-container",

	show : function(view){
		if(this.current)
			this.current.close();
		this.current = view;
		this.current.render();
		$(this.el).html(this.current.$el);
	}
};

new app.Router(app);
Backbone.history.start();