import { ComponentFixture, TestBed } from '@angular/core/testing';

import { VillagersComponent } from './villagers.component';

describe('VillagersComponent', () => {
  let component: VillagersComponent;
  let fixture: ComponentFixture<VillagersComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [VillagersComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(VillagersComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
