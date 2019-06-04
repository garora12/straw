import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { HttpClientModule } from '@angular/common/http';

import { SharedModule } from "../shared/shared.module";

import { LivePollsRoutingModule } from './live-polls-routing.module';
import { LivePollsListingComponent } from './live-polls-listing/live-polls-listing.component';

@NgModule({
  declarations: [
    LivePollsListingComponent
  ],
  imports: [
    CommonModule,
    LivePollsRoutingModule,
    SharedModule,
    HttpClientModule,
  ]
})
export class LivePollsModule { }
