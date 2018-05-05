import {BrowserModule} from '@angular/platform-browser';
import {NgModule} from '@angular/core';

import {AppComponent} from './app.component';
import {MainService} from './app.service';
import {FormsModule} from '@angular/forms';
import {HttpClientModule} from '@angular/common/http';
import {NgbModalModule, NgbAlertModule} from "@ng-bootstrap/ng-bootstrap";
import {NguiMapModule} from "@ngui/map";

@NgModule({
    declarations: [
        AppComponent
    ],
    imports: [
        BrowserModule,
        FormsModule,
        HttpClientModule,
        NgbModalModule.forRoot(),
        NgbAlertModule.forRoot(),
        NguiMapModule.forRoot({
            apiUrl: 'https://maps.google.com/maps/api/js?libraries=visualization,places,drawing&key=AIzaSyCLMYSWmhRhzAMf-hLcMafs3S-E3ifStjE'
        })
    ],
    providers: [MainService],
    bootstrap: [AppComponent]
})
export class AppModule {
}
