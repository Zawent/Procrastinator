package co.edu.procastinadont;

import android.app.ActivityManager;
import android.app.Service;
import android.content.Context;
import android.content.pm.ApplicationInfo;
import android.content.pm.PackageManager;
import android.graphics.HardwareBufferRenderer;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Spinner;
import android.widget.Toast;

import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;
import java.util.ArrayList;
import java.util.List;
import android.content.Intent;
import android.net.Uri;
import android.provider.Settings;
import android.os.Handler;
import android.content.BroadcastReceiver;
import android.content.IntentFilter;
import androidx.localbroadcastmanager.content.LocalBroadcastManager;
import android.content.ComponentName;
import android.os.IBinder;



public class InicioBloqueo extends AppCompatActivity {

    private Spinner spinnerApps;
    private EditText editTextTiempo;
    private Button btnIniciarBloqueo;
    private List<ApplicationInfo > installedApps;
    private String selectedAppName;
    private int selectedTime;
    private static final int REQUEST_CODE_DRAW_OVERLAY = 1234;
    private static final String TAG = "Primero";
    private Handler handler;

    private BroadcastReceiver appEnPrimerPlanoReceiver = new BroadcastReceiver() {
        @Override
        public void onReceive(Context context, Intent intent) {
            String appEnPrimerPlano = intent.getStringExtra("appEnPrimerPlano");
        }
    };
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        handler=new Handler();
        super.onCreate(savedInstanceState);
        setContentView(R.layout.bloqueador);

        LocalBroadcastManager.getInstance(this).registerReceiver(appEnPrimerPlanoReceiver,
                new IntentFilter("AppPrimera"));
        startService(new Intent(this, PrimeroService.class));
        LocalBroadcastManager.getInstance(this).registerReceiver(tiempoRestanteReceiver, new IntentFilter("TIEMPO_RESTANTE"));

        spinnerApps = findViewById(R.id.spinner_apps);
        editTextTiempo = findViewById(R.id.edit_text_tiempo);
        btnIniciarBloqueo = findViewById(R.id.boton_iniciar_bloqueo);

        installedApps = getAppsInstaladas();

        ArrayAdapter<String> adapter = new ArrayAdapter<>(this, android.R.layout.simple_spinner_dropdown_item, getNombreApps());
        spinnerApps.setAdapter(adapter);

        spinnerApps.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> parentView, View selectedItemView, int position, long id) {
                selectedAppName = getPackageManager().getApplicationLabel(installedApps.get(position)).toString();
            }

            @Override
            public void onNothingSelected(AdapterView<?> parentView) {
            }
        });

        btnIniciarBloqueo.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (selectedAppName != null && !editTextTiempo.getText().toString().isEmpty()) {
                    selectedTime = Integer.parseInt(editTextTiempo.getText().toString());
                    Log.d(TAG, "dataPrimer " + appEnPrimerPlanoReceiver.toString());
                    String AppPrimero= appEnPrimerPlanoReceiver.toString();

                    Intent intent = new Intent(InicioBloqueo.this, BloqueoService.class);
                    intent.putExtra("NombreApp", selectedAppName);
                    intent.putExtra("AppPrimerPlano", AppPrimero);
                    intent.putExtra("TiempoBloqueo", selectedTime);
                    startService(intent);

                    Toast.makeText(InicioBloqueo.this, "Iniciando bloqueo para " + selectedAppName + " durante " + selectedTime + " minutos", Toast.LENGTH_SHORT).show();
                } else {
                    Toast.makeText(InicioBloqueo.this, "Selecciona una aplicación y un tiempo válido", Toast.LENGTH_SHORT).show();
                }
            }
        });
        appEnPrimerPlanoReceiver.toString();
    }



    private BroadcastReceiver tiempoRestanteReceiver = new BroadcastReceiver() {
        @Override
        public void onReceive(Context context, Intent intent) {
            int tiempoRestante = intent.getIntExtra("tiempoRestante", 0);
            Log.d(TAG, "Tiempo restante: " + tiempoRestante + " segundos");
        }
    };

    private List<ApplicationInfo> getAppsInstaladas() {
        PackageManager packageManager = getPackageManager();
        return packageManager.getInstalledApplications(PackageManager.GET_META_DATA);
    }


    private List<String> getNombreApps() {
        List<String> appNames = new ArrayList<>();
        for (ApplicationInfo appInfo : installedApps) {
            Log.i("APP",appInfo.loadLabel(getPackageManager()).toString());
            appNames.add(appInfo.loadLabel(getPackageManager()).toString());
        }
        return appNames;
    }

    protected void onDestroy() {
        stopService(new Intent(this, PrimeroService.class));

        super.onDestroy();
        LocalBroadcastManager.getInstance(this).unregisterReceiver(appEnPrimerPlanoReceiver);
        LocalBroadcastManager.getInstance(this).unregisterReceiver(tiempoRestanteReceiver);
    }


    /*@Override
    protected void onStart() {
        super.onStart();
        handler.postDelayed(actualizarAppEnPrimerPlano, INTERVALO_ACTUALIZACION);
    }
    @Override
    protected void onStop() {
        super.onStop();
        handler.removeCallbacks(actualizarAppEnPrimerPlano);
    }

    private Runnable actualizarAppEnPrimerPlano = new Runnable() {
        @Override
        public void run() {
            String appPrimerPlano = Primero();
            Log.d(TAG, "App en primer plano: " + appPrimerPlano);
            handler.postDelayed(this, INTERVALO_ACTUALIZACION);
        }
    };

    private String Primero() {
        ActivityManager activityManager = (ActivityManager) getSystemService(Context.ACTIVITY_SERVICE);
        List<ActivityManager.RunningAppProcessInfo> appProcesses = activityManager.getRunningAppProcesses();
        PackageManager packageManager = getPackageManager();

        if (appProcesses != null && !appProcesses.isEmpty()) {
            for (ActivityManager.RunningAppProcessInfo appProcess : appProcesses) {
                if (appProcess.importance == ActivityManager.RunningAppProcessInfo.IMPORTANCE_FOREGROUND) {
                    try {
                        ApplicationInfo appInfo = packageManager.getApplicationInfo(appProcess.processName, PackageManager.GET_META_DATA);
                        CharSequence appName = packageManager.getApplicationLabel(appInfo);
                        return appName.toString();
                    } catch (PackageManager.NameNotFoundException e) {
                        e.printStackTrace();
                    }
                }
            }
        }
        return null;
    }*/

}