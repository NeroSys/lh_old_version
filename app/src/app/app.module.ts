import {BrowserModule} from '@angular/platform-browser';
import {NgModule} from '@angular/core';

import {AppComponent} from './app.component';
import {MainService} from './app.service';
import {HttpModule} from '@angular/http';
import {ReactiveFormsModule} from '@angular/forms';

@NgModule({
    declarations: [
        AppComponent
    ],
    imports: [
        BrowserModule,
        HttpModule,
        ReactiveFormsModule
    ],
    providers: [MainService],
    bootstrap: [AppComponent]
})
export class AppModule {
}
