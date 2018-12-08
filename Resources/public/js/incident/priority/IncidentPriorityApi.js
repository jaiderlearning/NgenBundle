/* 
 * This file is part of the Ngen - CSIRT Incident Report System.
 * 
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 * 
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

var IncidentPriorityApi = ApiClient.extend({
    config: function () {
//        this.api.add("networks", {stripTrailingSlash: true});
//        this.api.networks.add("report", {stripTrailingSlash: true});
        $.subscribe('/cert_unlp/incident/priority/activate', $.proxy(this.activate, this));
        $.subscribe('/cert_unlp/incident/priority/desactivate', $.proxy(this.desactivate, this));
        $.subscribe('/cert_unlp/incident/priority/new', $.proxy(this.create, this));
        $.subscribe('/cert_unlp/incident/priority/update', $.proxy(this.update, this));
    },
    addDefaultChannel: function () {
        this.api.add("descisions", {stripTrailingSlash: true, url: 'incidents/priorities'});
        this.defaultChannel = this.api.descisions;
    },
    changeState: function (networkId, isActive, callback) {

        var request = this.defaultChannel.update(networkId + "/" + (isActive ? "activate" : "desactivate"), {}, {apikey: this.apiKey});
        this.doRequest(request, callback);

    },
    activate: function (networkId, callback) {
        this.changeState(networkId, true, callback);
    },
    desactivate: function (networkId, callback) {
        this.changeState(networkId, false, callback);

    },
});
