import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PollMasterComponent } from './poll-master.component';

describe('PollMasterComponent', () => {
  let component: PollMasterComponent;
  let fixture: ComponentFixture<PollMasterComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PollMasterComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PollMasterComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
