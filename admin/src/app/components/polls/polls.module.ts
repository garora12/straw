import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { ReactiveFormsModule } from '@angular/forms';
import { FormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';
import { NgMultiSelectDropDownModule } from 'ng-multiselect-dropdown';

import { SharedModule } from "../shared/shared.module";

import { PollsRoutingModule } from './polls-routing.module';
import { PollsListingComponent } from './polls-listing/polls-listing.component';
import { PollMasterComponent } from './poll-master/poll-master.component';

@NgModule({
  declarations: [
    PollsListingComponent,
    PollMasterComponent
  ],
  imports: [
    CommonModule,
    PollsRoutingModule,
    SharedModule,
    ReactiveFormsModule,
    FormsModule,
    HttpClientModule,
    NgMultiSelectDropDownModule.forRoot()
  ]
})
export class PollsModule { }
