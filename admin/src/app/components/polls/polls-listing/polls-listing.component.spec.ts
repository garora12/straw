import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PollsListingComponent } from './polls-listing.component';

describe('PollsListingComponent', () => {
  let component: PollsListingComponent;
  let fixture: ComponentFixture<PollsListingComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PollsListingComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PollsListingComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
