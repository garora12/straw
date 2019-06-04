import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { ReactiveFormsModule } from '@angular/forms';
import { FormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';
import { NgMultiSelectDropDownModule } from 'ng-multiselect-dropdown';

import { SharedModule } from "../shared/shared.module";

import { UsersRoutingModule } from './users-routing.module';
import { UserMasterComponent } from './user-master/user-master.component';
import { UserListingComponent } from './user-listing/user-listing.component';

@NgModule({
  declarations: [
    UserMasterComponent,
    UserListingComponent,
  ],
  imports: [
    CommonModule,
    UsersRoutingModule,
    SharedModule,
    ReactiveFormsModule,
    FormsModule,
    HttpClientModule,
    NgMultiSelectDropDownModule.forRoot()
  ]
})
export class UsersModule { }
